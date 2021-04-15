<?php


namespace JackFlash\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class EavOptions extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('eav_attribute_option', 'option_id');
    }
}
