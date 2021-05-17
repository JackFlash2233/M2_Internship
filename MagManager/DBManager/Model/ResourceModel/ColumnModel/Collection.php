<?php


namespace MagManager\DBManager\Model\ResourceModel\ColumnModel;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MagManager\DBManager\Model\ColumnModel;
use MagManager\DBManager\Model\ResourceModel\ColumnResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(ColumnModel::class, ColumnResourceModel::class);
    }
}
