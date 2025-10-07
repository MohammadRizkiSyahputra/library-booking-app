<?php

namespace App\Models;

use App\Core\Model;

class VerifyModel extends Model
{
    public string $code = '';

    public function rules(): array
    {
        return [
            'code' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6], [self::RULE_MAX, 'max' => 6]]
        ];
    }
}
