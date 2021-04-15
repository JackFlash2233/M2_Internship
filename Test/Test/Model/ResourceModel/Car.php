<?php

namespace Test\Test\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Car extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('test_test_car', 'entity_id');
    }
}
