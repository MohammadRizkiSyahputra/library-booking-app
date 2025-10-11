<?php
namespace App\Core\Form;

class Form {
    public static function begin($action, $method, $options = []) {
        $enctype = $options['enctype'] ?? '';
        $enctypeAttr = $enctype ? sprintf(' enctype="%s"', htmlspecialchars($enctype)) : '';
        echo sprintf('<form action="%s" method="%s"%s>', $action, $method, $enctypeAttr);
        return new Form();
    }

    public static function end() {
        echo '</form>';
    }

    public function field($model, $attribute) {
        return new Field($model, $attribute);
    }

    public static function fileField($name, $label, $accept = null, $required = false) {
        $html = '<div>';
        $html .= sprintf('<label for="%s">%s</label>', htmlspecialchars($name), htmlspecialchars($label));
        $html .= sprintf(
            '<input type="file" id="%s" name="%s"%s%s>',
            htmlspecialchars($name),
            htmlspecialchars($name),
            $accept ? ' accept="' . htmlspecialchars($accept) . '"' : '',
            $required ? ' required' : ''
        );
        $html .= '</div>';
        return $html;
    }

    public static function button($text, $type = 'submit') {
        return sprintf('<button type="%s">%s</button>', htmlspecialchars($type), htmlspecialchars($text));
    }

    public static function hiddenField($name, $value) {
        return sprintf('<input type="hidden" name="%s" value="%s">', htmlspecialchars($name), htmlspecialchars($value));
    }
}
