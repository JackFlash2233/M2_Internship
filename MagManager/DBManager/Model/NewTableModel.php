<?php


namespace MagManager\DBManager\Model;


use Magento\Framework\Model\AbstractModel;
use MagManager\DBManager\Api\Data\NewTableInterface;

class NewTableModel extends AbstractModel implements NewTableInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel\NewTableModel::class);
    }

    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);

    }

    public function getColumnName()
    {
        return parent::getData(self::COLUMN_NAME);
    }

    public function setColumnName($columnName)
    {
        return $this->setData(self::COLUMN_NAME, $columnName);
    }

    public function getColumnType()
    {
        return parent::getData(self::COLUMN_TYPE);
    }

    public function setColumnType($columnType)
    {
        return $this->setData(self::COLUMN_TYPE, $columnType);
    }
}
