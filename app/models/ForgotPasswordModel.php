<?php

namespace App\Models;

use App\Core\Model;

class ForgotPasswordModel extends Model
{
    public string $email = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
        ];
    }
}
