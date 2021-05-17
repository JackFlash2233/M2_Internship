<?php


namespace MagManager\DBManager\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use MagManager\DBManager\Model\DbSchema;

/**
 * Class SaveInf
 */
class SaveInf extends Action
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
     * @var CacheInterface
     */
    private $cache;


    /**
     * SaveNewTable constructor.
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     * @param DbSchema $dbSchema
     * @param CacheInterface $cache
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        DbSchema $dbSchema,
        CacheInterface $cache
    )
    {
        parent::__construct($context);
        $this->connection = $resourceConnection->getConnection();
        $this->dbSchema = $dbSchema;
        $this->cache = $cache;
    }

    public function execute()
    {
        $oldTableName = $this->cache->load(self::TABLE_NAME);
        $newTableName = $this->getRequest()->getParam('table_name');
        $tableComment = $this->getRequest()->getParam('table_comment');

        if ($newTableName != $oldTableName)
        {
            $this->connection->renameTable($oldTableName, $newTableName);
            $this->dbSchema->deleteDB($oldTableName);
            $this->dbSchema->createDb($newTableName, $tableComment);
        } else {
            $this->dbSchema->upgradeDB($oldTableName, $tableComment);
        }


        $this->_redirect('*/*/index');
    }


}
