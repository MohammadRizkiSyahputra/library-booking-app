<?php
namespace App\Core\Form;

class Form {
    // Method ini dipakai untuk memulai tag <form>
    // Contoh pemakaian di view:
    // <?php $form = Form::begin('/login', 'post')
    public static function begin($action, $method) {
        // Cetak tag <form> dengan atribut action dan method
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        // Kembalikan instance Form supaya bisa lanjut panggil field()
        return new Form();
    }

    // Method ini menutup tag </form>
    // Dipanggil di akhir form
    public static function end() {
        echo '</form>';
    }

    // Method ini digunakan untuk membuat field input baru
    // Parameter: model (data yang di-bind) dan attribute (nama field)
    public function field($model, $attribute) {
        // Buat instance Field yang akan render input HTML
        return new Field($model, $attribute);
    }
}
