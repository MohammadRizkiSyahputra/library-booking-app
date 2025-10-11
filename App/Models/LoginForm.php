<?php

namespace App\Models;

use App\Core\Model;
use App\Core\App;

class LoginForm extends Model
{
    public string $identifier = '';
    public string $password = '';
    public bool $remember = false;

    public function rules(): array
    {
        return [
            'identifier' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 24]]
        ];
    }

    public function login(): bool
    {
        $user = User::findOne(['email' => $this->identifier]);

        if (!$user) {
            $user = User::findOne(['nim' => $this->identifier]);
        }

        if (!$user) {
            $user = User::findOne(['nip' => $this->identifier]);
        }

        if (!$user) {
            $this->addError('identifier', 'User not found');
            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        if ($user->status === 'banned' || $user->status === 'suspended') {
            $this->addError('identifier', 'Your account has been ' . $user->status);
            return false;
        }

        return App::$app->login($user, $this->remember);
    }
}
