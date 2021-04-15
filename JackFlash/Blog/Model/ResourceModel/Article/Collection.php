<?php


namespace JackFlash\Blog\Model\ResourceModel\Article;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\JackFlash\Blog\Model\Article::class, \JackFlash\Blog\Model\ResourceModel\Article::class);
    }
}
