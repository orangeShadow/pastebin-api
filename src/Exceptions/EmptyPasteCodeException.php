<?php
namespace OrangeShadow\PastebinApi\Exceptions;


class EmptyPasteCodeException extends \Exception
{
    public function __construct($message = "Paste code should not be empty!", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}