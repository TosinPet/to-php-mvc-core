<?php

namespace too\phpmvc\middlewares;

abstract class BaseMiddleware
{
    abstract public function execute();
}