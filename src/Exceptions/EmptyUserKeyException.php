<?php
namespace OrangeShadow\PastebinApi\Exceptions;


use Exception;

class EmptyUserKeyException extends \Exception
{

    public function __construct($message = "User api key should not be empty!", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}