<?php


namespace MagManager\DBManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ColumnResourceModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('table_column', 'entity_id');
    }
}
