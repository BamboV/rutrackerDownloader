<?php

namespace DAL\Adapters;

use BamboV\RutrackerAPI\Entities\RutrackerForum;
use BamboV\RutrackerAPI\Entities\RutrackerForumGroup;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class ForumGroupAdapter
{
    public function toArray(RutrackerForumGroup $entity)
    {
        return [
            'id' => $entity->getId(),
            'title' => $entity->getTitle(),
            'sub_forums' => array_map(function($item){
                return $this->toArrayForum($item);
            },$entity->getSubForums()),
        ];
    }

    public function manyToArray(array $groups)
    {
        return array_map(function($item){
            return $this->toArray($item);
        }, $groups);
    }

    private function toArrayForum(RutrackerForum $forum)
    {
        return [
            'id' => $forum->getId(),
            'title' => $forum->getTitle(),
        ];
    }

    public function toEntity(array $array)
    {
        return new RutrackerForumGroup($array['id'], $array['title'], array_map(function($item){
            return $this->formToEntity($item);
        }, $array['sub_forums']));
    }

    public function manyToEntity(array $array)
    {
        return array_map(function($item){
            return $this->toEntity($item);
        }, $array);
    }

    private function formToEntity(array $array)
    {
        return new RutrackerForum($array['id'], $array['title']);
    }

}
