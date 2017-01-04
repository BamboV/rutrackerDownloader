<?php

namespace Core\Transmission;

use Core\Rutracker\Interfaces\DownloadTorrentListenerInterface;
use Vohof\Transmission;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class TransmissionDownloadTorrentFileListener implements DownloadTorrentListenerInterface
{
    /**
     * @var string
     */
    private $host;
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var string
     */
    private $userName;
    /**
     * @var string
     */
    private $password;

    public function __construct(string $host, string $endpoint, string $userName = null, string $password = null)
    {

        $this->host = $host;
        $this->endpoint = $endpoint;
        $this->userName = $userName;
        $this->password = $password;
    }

    public function onDownload($content)
    {
        $transmission = new Transmission([
            'host' => $this->host,
            'endpoint' => $this->endpoint,
            'username' => $this->userName,
            'password' => $this->password,
        ]);
        $transmission->add(base64_encode($content), true);
    }

}
