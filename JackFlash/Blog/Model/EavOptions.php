<?php


namespace JackFlash\Blog\Model;

use JackFlash\Blog\Api\Data\EavOptionsInterface;
use Magento\Framework\Model\AbstractModel;

class EavOptions extends AbstractModel implements EavOptionsInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\EavOptions::class);
    }

    public function getId()
    {
        return parent::getData(self::OPTION_ID);
    }

    public function setId($optionId)
    {
        return $this->setData(self::OPTION_ID, $optionId);
    }

    public function getAttributeId()
    {
        return parent::getData(self::ATTRIBUTE_ID);
    }

    public function setAttributeId($attributeId)
    {
        return $this->setData(self::ATTRIBUTE_ID, $attributeId);
    }

    public function getSortOrder()
    {
        return parent::getData(self::SORT_ORDER);
    }

    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    public function getIsEnabled()
    {
        return parent::getData(self::IS_ENABLED);
    }

    public function setIsEnabled($isEnabled)
    {
        return $this->setData(self::IS_ENABLED, $isEnabled);
    }
}
