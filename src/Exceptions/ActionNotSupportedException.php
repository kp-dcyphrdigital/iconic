<?php

namespace SYG\Iconic\Exceptions;

use Exception;
use Throwable;

class ActionNotSupportedException extends Exception
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Action not currently supported';
        }
        parent::__construct($message, $code, $previous);
    }
}