<?php


namespace MagManager\DBManager\Model;


use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class EditColumnDataProvider
 */
class EditColumnDataProvider extends AbstractDataProvider
{
    const TABLE_NAME1 = 'table_name';
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
     * @var Http
     */
    private $request;

    /**
     * EditColumnDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ResourceModel\ColumnModel\Collection $collection
     * @param ResourceConnection $resourceConnection
     * @param CacheInterface $cache
     * @param Http $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        ResourceModel\ColumnModel\Collection $collection,
        ResourceConnection $resourceConnection,
        CacheInterface $cache,
        Http $request,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->connection = $resourceConnection->getConnection();
        $this->collection = $collection;
        $this->cache = $cache;
        $this->request = $request;
    }

    /**
     * @return array[]
     */
    public function getData(): array
    {
        $tableName = $this->cache->load(self::TABLE_NAME1);
        $columnName = $this->request->getParam('COLUMN_NAME');

        if (!$columnName) {
            $columnName = $this->cache->load(self::COLUMN_NAME);
        } else {
            $this->cache->save($columnName, self::COLUMN_NAME);
        }
        $values = [
            null => [
                'COLUMN_NAME' => '',
                'data_type' => 'smallint',
                'primary' => false,
                'nullable' => false
            ]
        ];
        try {
            $desc = $this->connection->describeTable($tableName);
            $values = [
                $columnName => [
                    'COLUMN_NAME' => $desc[$columnName]["COLUMN_NAME"],
                    'data_type' => $desc[$columnName]["DATA_TYPE"],
                    'primary' => $desc[$columnName]["PRIMARY"],
                    'nullable' => $desc[$columnName]["NULLABLE"]
                ]];
        } catch (\Exception $e) {

        }
        return $values;
    }
}
