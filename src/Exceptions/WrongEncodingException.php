<?php
namespace OrangeShadow\PastebinApi\Exceptions;


class WrongEncodingException extends \Exception
{
    public function __construct($message = 'Paste text should have UTF-8 encoding', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}