<?php


namespace MagManager\DBManager\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use MagManager\DBManager\Model\DbSchema;

/**
 * Class SaveColumn
 */
class SaveColumn extends Action
{
    const TABLE_NAME = 'table_name';
    const COLUMN_NAME = 'COLUMN_NAME';
    /**
     * @var AdapterInterface
     */
    private $connection;
    /**
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var DbSchema
     */
    private $dbSchema;

    /**
     * SaveColumn constructor.
     * @param Context $context
     * @param CacheInterface $cache
     * @param ResourceConnection $resourceConnection
     * @param DbSchema $dbSchema
     */
    public function __construct(
        Context $context,
        CacheInterface $cache,
        ResourceConnection $resourceConnection,
        DbSchema $dbSchema
    )
    {
        parent::__construct($context);
        $this->connection = $resourceConnection->getConnection();
        $this->cache = $cache;
        $this->dbSchema = $dbSchema;
    }

    public function execute()
    {
        $tableName = $this->cache->load(self::TABLE_NAME);
        $columnName = $this->getRequest()->getParam('COLUMN_NAME');
        $dataType = $this->getRequest()->getParam('data_type');
        $primary = $this->getRequest()->getParam('primary');
        $nullable = $this->getRequest()->getParam('nullable');
        $comment = 'test';

        $oldColumnName = $this->cache->load(self::COLUMN_NAME);

        $definition = [
            'type' => $dataType,
            'name' => $columnName,
            'comment' => $comment
        ];
//        primary
        if ($this->connection->tableColumnExists($tableName, $oldColumnName)) {
            $this->connection->changeColumn($tableName, $oldColumnName, $columnName, $definition);
        } else {
            $this->connection->addColumn($tableName, $columnName, $definition);
        }
        $this->dbSchema->upgradeDB($tableName, $comment);
        $this->cache->remove(self::COLUMN_NAME);
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');
    }


}
