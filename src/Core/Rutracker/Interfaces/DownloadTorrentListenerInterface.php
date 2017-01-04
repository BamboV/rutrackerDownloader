<?php

namespace Core\Rutracker\Interfaces;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface DownloadTorrentListenerInterface
{
    public function onDownload($content);
}
