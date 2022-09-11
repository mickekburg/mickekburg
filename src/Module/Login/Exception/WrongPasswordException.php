<?php

namespace Module\Login\Exception;

class WrongPasswordException extends \Exception
{
    protected $message = "Wrong password exception";
}