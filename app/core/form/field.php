<?php
namespace App\Core\Form;

use App\Core\Model;

class Field
{
    // ========================
    // TIPE INPUT YANG DIDUKUNG
    // ========================
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_EMAIL = 'email';
    public const TYPE_NUMBER = 'number';
    public const TYPE_TEXTAREA = 'textarea'; //  Tambahan: dukung textarea

    // Properti utama buat simpen data input
    public string $type;
    public Model $model;
    public string $attribute;
    public ?string $placeholder = null;
    public ?string $customLabel = null; 
    public ?int $colSpan = null; //  Tambahan: dukung grid col-span
    public ?int $rows = null;    //  Tambahan: untuk textarea jumlah baris

    // Konstruktor, otomatis deteksi tipe input berdasarkan nama field (misal email/password)
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;

        // Auto detect tipe input berdasarkan nama
        if (stripos($attribute, 'password') !== false) $this->type = self::TYPE_PASSWORD;
        if (stripos($attribute, 'email') !== false) $this->type = self::TYPE_EMAIL;
    }

    // ========================
    // METHOD BUAT SETTING FIELD
    // ========================
    public function type(string $type): self {
        $this->type = $type;
        return $this;
    }

    public function placeholder(string $text): self {
        $this->placeholder = $text;
        return $this;
    }

    public function label(string $text): self { 
        $this->customLabel = $text;
        return $this;
    }

    //  Tambahan: untuk grid responsive (misal col-span-2)
    public function colSpan(int $cols): self {
        $this->colSpan = $cols;
        return $this;
    }

    //  Tambahan: khusus textarea biar bisa atur jumlah baris
    public function rows(int $rows): self {
        $this->rows = $rows;
        return $this;
    }

    // Helper buat mencegah XSS (escape HTML)
    protected function e(string $v): string {
        return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
    }

    // ============================================
    // BAGIAN INI YANG NGATUR DESAIN / TAMPILAN UI
    // ============================================
    public function __toString(): string {
        // Label default diubah jadi huruf besar awal tiap kata
        $label = $this->customLabel ?? ucfirst(str_replace('_', ' ', $this->attribute));

        // BAGIAN DESAIN FIELD (KALAU MAU UBAH STYLE GANTI DI SINI)
        $baseInput = 'w-full px-3 py-2 rounded-lg border shadow-sm focus:outline-none focus:ring-2'; // <-- style dasar input
        $okInput = ' border-gray-300 focus:ring-indigo-500 focus:border-indigo-500'; // <-- style input normal
        $errInput = ' border-red-500 focus:ring-red-500 focus:border-red-500'; // <-- style input error

        // Deteksi apakah field ini punya error
        $hasError = $this->model->hasError($this->attribute);
        $msg = $this->model->getFirstError($this->attribute);
        $value = $this->type === self::TYPE_PASSWORD ? '' : ($this->model->{$this->attribute} ?? '');

        // ======================================================
        // SEMUA KODE DI BAWAH INI NGATUR STRUKTUR HTML FIELD
        // ======================================================
        //  Tambahan: col-span support
        $colClass = $this->colSpan ? ' md:col-span-' . $this->colSpan : '';

        $html  = '<div class="mb-4' . $colClass . '">'; // Container tiap field (support grid)

        // Label field
        $html .= sprintf(
            '<label class="block text-sm font-medium %s mb-2" for="%s">%s</label>',
            $hasError ? 'text-red-700' : 'text-gray-700', //  warna label berubah kalau ada error
            $this->e($this->attribute),
            $this->e($label)
        );

        // =====================
        // Tipe Input vs Textarea
        // =====================
        if ($this->type === self::TYPE_TEXTAREA) {
            $html .= sprintf(
                '<textarea id="%s" name="%s" %s rows="%d" class="%s%s">%s</textarea>',
                $this->e($this->attribute),
                $this->e($this->attribute),
                $this->placeholder ? 'placeholder="'.$this->e($this->placeholder).'"' : '',
                $this->rows ?? 4, // default 4 baris
                $baseInput,
                $hasError ? $errInput : $okInput,
                $this->e((string)$value)
            );
        } else {
            $html .= sprintf(
                '<input id="%s" type="%s" name="%s" value="%s" %s class="%s%s" />',
                $this->e($this->attribute),
                $this->e($this->type),
                $this->e($this->attribute),
                $this->e((string)$value),
                $this->placeholder ? 'placeholder="'.$this->e($this->placeholder).'"' : '',
                $baseInput, // ubah padding, border-radius, shadow, dsb di sini
                $hasError ? $errInput : $okInput //  warna fokus & border diatur di sini
            );
        }

        // Pesan error (muncul kalau validasi gagal)
        if ($hasError && $msg) {
            $html .= sprintf('<p class="mt-1 text-sm text-red-600">%s</p>', $this->e($msg)); //  ubah font-size, warna, atau margin error di sini
        }

        $html .= '</div>'; // Tutup container field
        return $html;
    }

    public function otpStyle(): self {
    $this->customLabel = 'Verification Code';
    $this->type = self::TYPE_TEXT;
    $this->placeholder = 'Enter 6-character code';
    return $this;
    }
}
