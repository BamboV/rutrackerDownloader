<?php

namespace Core\Rutracker\Exceptions;

use Exception;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerSearchOptionsException extends RutrackerException
{
    public function __construct($field)
    {
        parent::__construct("Field ".$field."is required!", 0, null);
    }
}
