<?php


namespace MagManager\DBManager\Model;

use Magento\Framework\Model\AbstractModel;

class ColumnModel extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(\MagManager\DBManager\Model\ResourceModel\ColumnResourceModel::class);
    }

}
