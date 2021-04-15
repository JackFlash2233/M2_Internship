<?php

namespace Test\Test\Model;

use Magento\Framework\Model\AbstractModel;

class Car extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Test\Test\Model\ResourceModel\Car::class);
    }
}
