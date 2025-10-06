<?php

namespace App\Core\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'Oops! The page you`re looking for doesn`t exist.';
    protected $code = 404;
}
