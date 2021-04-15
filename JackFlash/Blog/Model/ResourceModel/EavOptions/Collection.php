<?php


namespace JackFlash\Blog\Model\ResourceModel\EavOptions;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\JackFlash\Blog\Model\EavOptions::class, \JackFlash\Blog\Model\ResourceModel\EavOptions::class);
    }
}
