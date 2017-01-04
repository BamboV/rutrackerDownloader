<?php

namespace DAL;

use Core\Rutracker\Exceptions\RutrackerFileIOException;
use Core\Rutracker\Interfaces\CookieRepositoryInterface;
use Core\Rutracker\Interfaces\FileIOInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class CookieFileRepository extends AbstractFileRepository implements CookieRepositoryInterface
{
    /**
     * @var string
     */
    protected $file = 'cookies.txt';

    /**
     * @var string
     */
    protected $folder = 'cookies';

    /**
     * @param array $cookies
     */
    public function setCookies(array $cookies)
    {
        $c = '';
        foreach($cookies as $cookie) {
            $c.=$cookie."\n";
        }
        $this->fileIO->writeFile($c, $this->getFilePath());
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        try {
            return explode("\n", $this->fileIO->readFile($this->getFilePath()));
        } catch (RutrackerFileIOException $ex) {
            return [];
        }
    }
}
