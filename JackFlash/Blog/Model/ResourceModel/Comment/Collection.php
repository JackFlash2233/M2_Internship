<?php


namespace JackFlash\Blog\Model\ResourceModel\Comment;

use JackFlash\Blog\Model\Comment;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Comment::class, \JackFlash\Blog\Model\ResourceModel\Comment::class);
    }
}
