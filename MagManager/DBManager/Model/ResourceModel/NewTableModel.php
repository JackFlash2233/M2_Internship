<?php


namespace MagManager\DBManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;

class NewTableModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('table_column', 'entity_id');
    }
}
