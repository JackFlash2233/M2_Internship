<?php

namespace MagManager\DBManager\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\TableFactory;
use MagManager\DBManager\Model\DbSchema;
use MagManager\DBManager\Model\EditTable;
use Zend_Db_Exception;

/**
 * Class SaveNewTable
 */
class SaveNewTable extends Action
{
    const TABLE_NAME = 'table_name';
    /**
     * @var AdapterInterface
     */
    private $connection;
    /**
     * @var DbSchema
     */
    private $dbSchema;
    /**
     * @var TableFactory
     */
    private $table;
    /**
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var EditTable
     */
    private $editTable;

    /**
     * SaveNewTable constructor.
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     * @param TableFactory $table
     * @param DbSchema $dbSchema
     * @param CacheInterface $cache
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        TableFactory $table,
        DbSchema $dbSchema,
        CacheInterface $cache,
        EditTable $editTable
    )
    {
        parent::__construct($context);
        $this->connection = $resourceConnection->getConnection();
        $this->table = $table;
        $this->dbSchema = $dbSchema;
        $this->cache = $cache;
        $this->editTable = $editTable;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     * @throws Zend_Db_Exception
     */
    public function execute()
    {
        $oldTableName = $this->getRequest()->getParam('old_table_name');
        $tableName = $this->getRequest()->getParam('table_name');
        $dynamicRowData = $this->getRequest()->getParam('dynamic_rows_container');
        $tableComment = 'test';
        $isRenamed = false;
        // check is new table
        if ($oldTableName == '') { //
            $this->editTable->createNewTable($tableName, $dynamicRowData);
        } else {
            if ($oldTableName != $tableName) {
                $this->editTable->renameTable($oldTableName, $tableName, $tableComment);
                $isRenamed = true;
            }
            $this->editTable->deleteColumn($tableName, $dynamicRowData);
            $this->editTable->editTable($tableName, $dynamicRowData);
            $this->dbSchema->upgradeDB($tableName, $tableComment);
        }
        $this->messageManager->addSuccessMessage(__('Table have been saved successfully'));

        $this->_redirect('*/*/index');
    }



}
