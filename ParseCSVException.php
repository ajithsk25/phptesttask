<?php

/**
 * Custom exception class for CSV parse
 *
 * @author <ajith.sk25@gmail.com>
 * @package test
 *
 */
class ParseCSVException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
}
