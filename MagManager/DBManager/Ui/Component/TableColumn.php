<?php


namespace MagManager\DBManager\Ui\Component;

use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns;
use MagManager\DBManager\Ui\Component\Listing\Column\CustomColumnCreator;

/**
 * Class TableColumn
 */
class TableColumn extends Columns
{
    /**
     * @var CustomColumnCreator
     */
    private $columnCreator;
    /**
     * @var Http
     */
    private $request;
    /**
     * @var AdapterInterface
     */
    private $connection;

    /**
     * TableColumn constructor.
     * @param ContextInterface $context
     * @param CustomColumnCreator $columnCreator
     * @param Http $request
     * @param ResourceConnection $resourceConnection
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        CustomColumnCreator $columnCreator,
        Http $request,
        ResourceConnection $resourceConnection,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $components, $data);
        $this->columnCreator = $columnCreator;
        $this->request = $request;
        $this->connection = $resourceConnection->getConnection();
    }

    public function prepare()
    {
        if (isset($this->components)) {
            $fields = $this->getFields();

            foreach ($fields as $field) {
                $column = $this->columnCreator->addColumn(
                    $this->context,
                    $field,
                    $field
                );
                $column->prepare();
                $this->addComponent($field, $column);
            }
        }
        parent::prepare();
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        $fields = [];
        $tableName = $this->request->getParam('table_name');
        if (isset($tableName)) {
            $fieldsTable = $this->connection->describeTable($tableName);
            foreach ($fieldsTable as $key => $field) {
                $fields[] = $key;
            }
        }
        return $fields;
    }
}
