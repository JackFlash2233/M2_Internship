<?php


namespace MagManager\DBManager\Controller\Adminhtml\Index;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use MagManager\DBManager\Model\DbSchema;

/**
 * Class Delete
 */
class Delete extends Action
{
    const DEFAULT = 'default';
    /**
     * @var AdapterInterface
     */
    private $connection;
    /**
     * @var DbSchema
     */
    private $dbSchema;

    /**
     * Delete constructor.
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     * @param DbSchema $dbSchema
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        DbSchema $dbSchema
    )
    {
        parent::__construct($context);
        $this->connection = $resourceConnection->getConnection();
        $this->dbSchema = $dbSchema;
    }

    public function execute()
    {
        $tableName = $this->getRequest()->getParam('table_name');

        $try = $this->connection->getTables($tableName);

        if ($try) {
            $this->connection->dropTable($tableName);
        }
        $this->dbSchema->deleteDB($tableName);
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }

}
