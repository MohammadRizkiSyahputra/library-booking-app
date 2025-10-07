<?php

namespace App\Models;

use App\Core\Model;

class ResetPasswordModel extends Model
{
    public string $code = '';
    public string $password = '';
    public string $confirm_password = '';

    public function rules(): array
    {
        return [
            'code' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6], [self::RULE_MAX, 'max' => 6]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 24]],
            'confirm_password' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }
}
