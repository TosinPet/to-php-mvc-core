<?php

namespace too\phpmvc\exception;

class NotFoundException extends \Exception
{
    protected $message = 'Page not Found';
    protected $code = 404;
}