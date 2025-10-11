<?php

namespace App\Core\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'Page not found. The requested resource does not exist.';
    protected $code = 404;
}
