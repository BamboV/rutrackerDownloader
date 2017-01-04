<?php

namespace Core\Rutracker\Services;

use BamboV\RutrackerAPI\Entities\Options\SearchOptions;
use BamboV\RutrackerAPI\Parsers\SymfonyForumGroupParser;
use BamboV\RutrackerAPI\Parsers\SymfonyParser;
use BamboV\RutrackerAPI\RutrackerAPI;
use Core\Rutracker\Interfaces\DownloadTorrentListenerInterface;
use DAL\Add3s3s\Rutracker3s3sSender;
use DAL\CookieFileRepository;
use DAL\ForumGroupFileRepository;
use DAL\ForumGroupSourceRepository;
use Core\Rutracker\Entities\Settings;
use DAL\FileIO;
use Core\Rutracker\Interfaces\FileIOInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RutrackerService
{
    /**
     * @var RutrackerAPI
     */
    private $rutrackerAPI;
    /**
     * @var FileIOInterface
     */
    private $fileIO;
    /**
     * @var Settings
     */
    private $settings;
    /**
     * @var DownloadTorrentListenerInterface
     */
    private $downloadTorrentListener;


    /**
     * RutrackerService constructor.
     *
     * @param bool $newLogin
     * @param DownloadTorrentListenerInterface $downloadTorrentListener
     * @param string $rutrackerLogin
     * @param string $rutrackerPassword
     */
    public function __construct(
        DownloadTorrentListenerInterface $downloadTorrentListener,
        string $rutrackerLogin,
        string $rutrackerPassword,
        bool $newLogin = false
    )
    {
        $this->fileIO = new FileIO();

        $cookies = new CookieFileRepository($this->fileIO);

        $this->rutrackerAPI = new RutrackerAPI(
            $rutrackerLogin,
            $rutrackerPassword,
            new Rutracker3s3sSender(),
            new SymfonyParser(),
            new SymfonyForumGroupParser(),
            $newLogin?[]:$cookies->getCookies()
        );
        $cookies->setCookies($this->rutrackerAPI->getCookies());
        $this->downloadTorrentListener = $downloadTorrentListener;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function downloadTorrentFile(int $id)
    {
        $file = $this->rutrackerAPI->downloadTorrent($id);
        $this->downloadTorrentListener->onDownload($file);
        return $file;
//        $path = $this->fileIO->writeFile(
//            $file,
//            $this->settings->getDefaultPath().$id.'.torrent'
//        );
//        if($scriptPath = $this->settings->getOnTorrentDownloadScriptPath()) {
//            exec($scriptPath.' '.$path);
//        }
    }

    /**
     * @param bool $reload
     *
     * @return array
     */
    public function getForums($reload = false)
    {
        $forumGroupRepository = new ForumGroupFileRepository($this->fileIO);
        $forumGroupSource = new ForumGroupSourceRepository($this->rutrackerAPI);

        if(!$reload) {
            try {
                return $forumGroupRepository->getAll();
            } catch (\Exception $ex){
                $forumGroups = $forumGroupSource->getAll();
                $forumGroupRepository->saveAll($forumGroups);
                return $forumGroups;
            }
        }
        $forumGroups = $forumGroupSource->getAll();
        $forumGroupRepository->saveAll($forumGroups);
        return $forumGroups;
    }

    /**
     * @param SearchOptions $options
     *
     * @return array|\BamboV\RutrackerAPI\Entities\RutrackerTopic[]
     */
    public function search(SearchOptions $options)
    {
        return $this->rutrackerAPI->search($options);
    }
}
