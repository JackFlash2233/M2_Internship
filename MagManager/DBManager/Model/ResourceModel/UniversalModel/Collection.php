<?php


namespace MagManager\DBManager\Model\ResourceModel\UniversalModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\MagManager\DBManager\Model\NewTableModel::class,
            \MagManager\DBManager\Model\ResourceModel\NewTableModel::class);
    }
}
