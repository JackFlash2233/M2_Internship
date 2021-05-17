<?php


namespace MagManager\DBManager\Api\Data;


interface NewTableInterface
{
    const ENTITY_ID = 'entity_id';
    const COLUMN_NAME = 'column_name';
    const COLUMN_TYPE = 'column_type';

    public function getId();

    public function setId($id);

    public function getColumnName();

    public function setColumnName($columnName);

    public function getColumnType();

    public function setColumnType($columnType);
}
