<?php

namespace Core\Rutracker\Exceptions;

use Exception;


/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerFileIOException extends RutrackerException
{
    public function __construct($message = 'File not found', $code=0, Exception $previous=null)
    {
        parent::__construct($message, $code, $previous);
    }
}
