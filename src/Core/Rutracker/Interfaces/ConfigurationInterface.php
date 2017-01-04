<?php

namespace Core\Rutracker\Interfaces;

use Core\Rutracker\Entities\Settings;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface ConfigurationInterface
{
    /**
     * @return Settings
     */
    public function getSettings(): Settings;
}
