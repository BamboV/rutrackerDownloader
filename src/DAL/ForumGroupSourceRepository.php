<?php

namespace DAL;

use BamboV\RutrackerAPI\RutrackerAPI;
use Core\Rutracker\Interfaces\ForumGroupRepositoryInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class ForumGroupSourceRepository implements ForumGroupRepositoryInterface
{
    /**
     * @var RutrackerAPI
     */
    private $rutrackerAPI;

    /**
     * ForumGroupSourceRepository constructor.
     *
     * @param RutrackerAPI $rutrackerAPI
     */
    public function __construct(RutrackerAPI $rutrackerAPI)
    {
        $this->rutrackerAPI = $rutrackerAPI;
    }

    public function getAll()
    {
        return $this->rutrackerAPI->getAllForums();
    }
}
