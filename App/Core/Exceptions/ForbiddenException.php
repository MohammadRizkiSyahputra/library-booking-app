<?php

namespace App\Core\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    protected $message = 'Access denied. You do not have permission to view this page.';
    protected $code = 403;
}
