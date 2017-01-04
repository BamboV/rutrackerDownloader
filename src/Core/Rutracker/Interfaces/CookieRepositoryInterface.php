<?php

namespace Core\Rutracker\Interfaces;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface CookieRepositoryInterface
{
    /**
     * @param array $cookies
     */
    public function setCookies(array $cookies);

    /**
     * @return array
     */
    public function getCookies();
}
