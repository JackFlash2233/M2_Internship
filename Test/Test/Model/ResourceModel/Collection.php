<?php

namespace Test\Test\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Test\Test\Model\Car::class, Car::class);
    }
}
