<?php
namespace App\Core;

// Kelas dasar (abstrak) untuk semua model
// Fokusnya di bagian validasi data dan handling error sebelum disimpan ke database
abstract class Model
{
    // Kumpulan jenis aturan validasi yang didukung
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_NUMBER = 'number';
    public const RULE_UNIQUE = 'unique';

    // Menyimpan error per atribut
    public array $errors = [];

    // Mengisi property model dengan data dari form (biasanya $_POST)
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            // Kalau property-nya ada di model, isi nilainya
            if (property_exists($this, $key)) {
                // Jika string, hapus spasi berlebih
                $this->{$key} = is_string($value) ? trim($value) : $value;
            }
        }
    }

    // Setiap model wajib punya daftar aturan validasi sendiri
    abstract public function rules(): array;

    // Fungsi utama untuk melakukan validasi semua atribut
    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute} ?? null;

            foreach ($rules as $rule) {
                // Nama aturan (bisa string sederhana atau array dengan parameter)
                $ruleName = is_string($rule) ? $rule : $rule[0];

                // 1) REQUIRED — wajib diisi
                if ($ruleName === self::RULE_REQUIRED && ($value === null || $value === '')) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                    continue;
                }

                if ($ruleName === self::RULE_EMAIL && $value) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->addErrorForRule($attribute, self::RULE_EMAIL);
                        continue;
                    }

                    $domain = strtolower(substr(strrchr($value, '@'), 1));
                    $allowed = ['stu.pnj.ac.id'];
                    $departments = ['akuntansi', 'grafika', 'tik', 'mesin', 'sipil', 'bisnis', 'elektro'];

                    // Check if ends with stu.pnj.ac.id or one of the <dept>.pnj.ac.id
                    $valid = in_array($domain, $allowed, true)
                        || preg_match('/^(' . implode('|', $departments) . ')\.pnj\.ac\.id$/', $domain);

                    if (!$valid) {
                        $this->addError($attribute, 'Use a valid PNJ email (e.g. @stu.pnj.ac.id or @<dept>.pnj.ac.id).');
                        continue;
                    }
                }

                // 3) MIN — panjang minimal
                if ($ruleName === self::RULE_MIN && isset($rule['min']) && $value !== null) {
                    if (mb_strlen((string)$value) < (int)$rule['min']) {
                        $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                    }
                }

                // 4) MAX — panjang maksimal
                if ($ruleName === self::RULE_MAX && isset($rule['max']) && $value !== null) {
                    if (mb_strlen((string)$value) > (int)$rule['max']) {
                        $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                    }
                }

                // 5) MATCH — harus sama dengan field lain (misal konfirmasi password)
                if ($ruleName === self::RULE_MATCH && isset($rule['match'])) {
                    $matchAttr = $rule['match'];
                    $matchVal  = $this->{$matchAttr} ?? null;
                    if ($value !== $matchVal) {
                        $this->addErrorForRule($attribute, self::RULE_MATCH, ['match' => $matchAttr]);
                    }
                }

                // 6) NUMBER — harus angka
                if ($ruleName === self::RULE_NUMBER && $value !== null && $value !== '') {
                    if (!ctype_digit((string)$value)) {
                        $this->addErrorForRule($attribute, self::RULE_NUMBER);
                    }
                }

                // 7) UNIQUE — pastikan tidak duplikat di database
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = App::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();

                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }

        // Return true kalau tidak ada error
        return empty($this->errors);
    }

    // Tambahkan error sesuai aturan validasi yang gagal
    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? 'Invalid value';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", (string)$value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    // Tambahkan error manual (misal dari proses lain)
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    // Daftar pesan default untuk tiap rule validasi
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required.',
            self::RULE_EMAIL => 'Use a valid PNJ email (e.g. @stu.pnj.ac.id or @<dept>.pnj.ac.id).',
            self::RULE_MIN => 'Min length is {min} characters.',
            self::RULE_MAX => 'Max length is {max} characters.',
            self::RULE_MATCH => 'This field must match {match}.',
            self::RULE_NUMBER => 'This field must contain digits only.',
            self::RULE_UNIQUE => 'Record with this {field} already exists.',
        ];
    }

    // Mengecek apakah ada error di atribut tertentu
    public function hasError(string $attribute): bool
    {
        return !empty($this->errors[$attribute] ?? []);
    }

    // Mengambil error pertama dari atribut tertentu (biasanya untuk ditampilkan di view)
    public function getFirstError(string $attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }
}
