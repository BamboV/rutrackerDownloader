<?php

namespace DAL;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractFileRepository
{
    /**
     * @var FileIO
     */
    protected $fileIO;

    /**
     * @var string
     */
    private $fileRootFolder = '/var/www/web/storage';

    /**
     * @var string
     */
    protected $folder;

    /**
     * @var string
     */
    protected $file;

    /**
     * ForumGroupFileRepository constructor.
     *
     * @param FileIO $fileIO
     */
    public function __construct(FileIO $fileIO)
    {
        $this->fileIO = $fileIO;
    }

    protected function getFilePath()
    {
        return $this->fileRootFolder.DIRECTORY_SEPARATOR.
            ($this->folder?$this->folder.DIRECTORY_SEPARATOR:'').
            $this->file;
    }

}
