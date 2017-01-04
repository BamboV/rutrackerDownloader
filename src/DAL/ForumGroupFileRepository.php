<?php

namespace DAL;

use Core\Rutracker\Exceptions\RutrackerFileIOException;
use DAL\Adapters\ForumGroupAdapter;
use Core\Rutracker\Interfaces\ForumGroupRepositoryInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class ForumGroupFileRepository extends AbstractFileRepository implements ForumGroupRepositoryInterface
{
    /**
     * @var string
     */
    protected $file = 'forums.json';

    /**
     * @return array
     *
     * @throws RutrackerFileIOException
     */
    public function getAll()
    {
        $text = $this->fileIO->readFile($this->getFilePath());

        if(empty($text)) {
            throw new RutrackerFileIOException();
        }

        return (new ForumGroupAdapter())->manyToEntity(json_decode($text, true));
    }

    /**
     * @param array $forumGroups | ForumGroup[]
     */
    public function saveAll(array $forumGroups)
    {
        $this->fileIO->writeFile(json_encode((new ForumGroupAdapter())->manyToArray($forumGroups)), $this->getFilePath());
    }

}
