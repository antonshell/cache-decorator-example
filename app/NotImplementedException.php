<?php

namespace app;

use BadMethodCallException;

/**
 * Class NotImplementedException
 * @package app
 */
class NotImplementedException extends BadMethodCallException
{
    protected $message = 'Not implemented';
}