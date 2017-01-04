<?php

namespace Core\Rutracker\Interfaces;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface CommandInterface
{
    public function invoke(array $params);
}
