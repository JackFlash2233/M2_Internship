<?php


namespace MagManager\DBManager\Model;


use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\TableFactory;
use Zend_Db_Exception;

/**
 * Class EditTable
 */
class EditTable
{
    /**
     * @var TableFactory
     */
    private $table;
    /**
     * @var DbSchema
     */
    private $dbSchema;
    /**
     * @var AdapterInterface
     */
    private $connection;

    public function __construct(
        ResourceConnection $resourceConnection,
        TableFactory $table,
        DbSchema $dbSchema
    )
    {
        $this->connection = $resourceConnection->getConnection();
        $this->table = $table;
        $this->dbSchema = $dbSchema;
    }

    /**
     * @param $tableName
     * @param $dynamicRowData
     * @throws Zend_Db_Exception
     */
    public function createNewTable($tableName, $dynamicRowData)
    {
        $table = $this->table->create();
//            $comment = $this->getRequest()->getParam('table_comment');
        $table->setName($tableName);
        foreach ($dynamicRowData as $datum) {
            $columnName = $datum['column_name'];
            $columnType = $datum['column_type'];
//                $columnComment = $datum['column_comment'];
            $size = null;
            $option = ['primary' => $datum['primary'], 'nullable' => $datum['null']];
//                $table->addColumn($columnName, $columnType, $option, $columnComment);
            $table->addColumn($columnName, $columnType, $option);
        }
        $this->connection->createTable($table);
        $comment = 'test';
        $this->dbSchema->createDb($tableName, $comment);
    }

    /**
     * @param $oldTableName
     * @param $tableName
     * @param $tableComment
     */
    public function renameTable($oldTableName, $tableName, $tableComment)
    {
        $this->connection->renameTable($oldTableName, $tableName);
        $this->dbSchema->deleteDB($oldTableName);
        $this->dbSchema->createDb($tableName, $tableComment);
    }

    public function editTable($tableName, $dynamicRowData)
    {
        foreach ($dynamicRowData as $rowDatum) {
            $columnName = $rowDatum['column_name'];
            $columnType = $rowDatum['column_type'];
            $nullable = $rowDatum['null'];
            $primary = $rowDatum['primary'];
            $comment = 'test';
            $oldColumnName = $rowDatum['old_column_name'];
//            if ($primary)
//            {
//                $definition = [
//                    'name' => $columnName,
//                    'type' => $columnType,
//                    'comment' => $comment,
//                    'nullable' => $nullable,
//                    'primary' => $columnName
//                ];
//            }
            $definition = [
                'name' => $columnName,
                'type' => $columnType,
                'comment' => $comment,
                'nullable' => $nullable
            ];
            if ($oldColumnName == '') {
                $this->connection->addColumn($tableName, $columnName, $definition);
            } else {
                if ($oldColumnName != $columnName) {
                    $this->connection->changeColumn($tableName, $oldColumnName, $columnName, $definition);
                } else {
                    $this->connection->modifyColumn($tableName, $columnName, $definition);
                }
            }
        }
    }

    /**
     * @param $tableName
     * @param $dynamicRowData
     */
    public function deleteColumn($tableName, $dynamicRowData)
    {
        $decs = $this->connection->describeTable($tableName);
        $fields = array_keys($decs);
        $oldTableNames =[];
        foreach ($dynamicRowData as $rowDatum)
        {
            $oldTableNames[] = $rowDatum['old_column_name'];
        }
        $diff = array_diff($fields, $oldTableNames);

        foreach ($diff as $item)
        {
            $this->connection->dropColumn($tableName, $item);
        }
    }
}
