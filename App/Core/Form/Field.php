<?php
namespace App\Core\Form;

use App\Core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_EMAIL = 'email';
    public const TYPE_NUMBER = 'number';
    public const TYPE_TEXTAREA = 'textarea';

    public string $type;
    public Model $model;
    public string $attribute;
    public ?string $placeholder = null;
    public ?string $customLabel = null; 
    public ?int $colSpan = null;
    public ?int $rows = null;

    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;

        if (stripos($attribute, 'password') !== false) $this->type = self::TYPE_PASSWORD;
        if (stripos($attribute, 'email') !== false) $this->type = self::TYPE_EMAIL;
    }

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

    public function colSpan(int $cols): self {
        $this->colSpan = $cols;
        return $this;
    }

    public function rows(int $rows): self {
        $this->rows = $rows;
        return $this;
    }

    protected function e(string $v): string {
        return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
    }

    public function __toString(): string {
        $label = $this->customLabel ?? ucfirst(str_replace('_', ' ', $this->attribute));
        $baseInput = 'w-full px-3 py-2 rounded-lg border shadow-sm focus:outline-none focus:ring-2';
        $okInput = ' border-gray-300 focus:ring-indigo-500 focus:border-indigo-500';
        $errInput = ' border-red-500 focus:ring-red-500 focus:border-red-500';

        $hasError = $this->model->hasError($this->attribute);
        $msg = $this->model->getFirstError($this->attribute);
        $value = $this->type === self::TYPE_PASSWORD ? '' : ($this->model->{$this->attribute} ?? '');
        $colClass = $this->colSpan ? ' md:col-span-' . $this->colSpan : '';

        $html  = '<div class="mb-4' . $colClass . '">';
        $html .= sprintf(
            '<label class="block text-sm font-medium %s mb-2" for="%s">%s</label>',
            $hasError ? 'text-red-700' : 'text-gray-700',
            $this->e($this->attribute),
            $this->e($label)
        );

        if ($this->type === self::TYPE_TEXTAREA) {
            $html .= sprintf(
                '<textarea id="%s" name="%s" %s rows="%d" class="%s%s">%s</textarea>',
                $this->e($this->attribute),
                $this->e($this->attribute),
                $this->placeholder ? 'placeholder="'.$this->e($this->placeholder).'"' : '',
                $this->rows ?? 4,
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
                $baseInput,
                $hasError ? $errInput : $okInput
            );
        }

        if ($hasError && $msg) {
            $html .= sprintf('<p class="mt-1 text-sm text-red-600">%s</p>', $this->e($msg));
        }

        $html .= '</div>';
        return $html;
    }

    public function otpStyle(): self {
    $this->customLabel = 'Verification Code';
    $this->type = self::TYPE_TEXT;
    $this->placeholder = 'Enter 6-character code';
    return $this;
    }
}
