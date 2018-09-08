<?php
namespace OrangeShadow\PastebinApi\Exceptions;


class EmptyPasteKeyException extends \Exception
{
    public function __construct($message = "User paste key should not be empty!", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}