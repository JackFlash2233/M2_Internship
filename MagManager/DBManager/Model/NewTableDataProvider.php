<?php


namespace MagManager\DBManager\Model;


use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use MagManager\DBManager\Model\ResourceModel\UniversalModel\Collection;

/**
 * Class NewTableDataProvider
 */
class NewTableDataProvider extends AbstractDataProvider
{
    const TABLE_NAME = 'table_name';
    private $loadedData;
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var AdapterInterface
     */
    private $connection;
    /**
     * @var Http
     */
    private $request;
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * NewTableDataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param Collection $collection
     * @param ResourceConnection $resourceConnection
     * @param Http $request
     * @param CacheInterface $cache
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        ResourceConnection $resourceConnection,
        Http $request,
        CacheInterface $cache,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->connection = $resourceConnection->getConnection();
        $this->request = $request;
        $this->cache = $cache;
    }

    public function getData()
    {
        if (!$this->getCollection()) {
            $this->getCollection();
        }
        return $this->getCollection();
    }

    public function getCollection(): array
    {
        $this->request->getParams();
        $tableName = $this->request->getParam('table_name');

//        if (!$tableName) {
//            $tableName = $this->cache->load(self::TABLE_NAME);
//        } else {
//            $this->cache->save($tableName, self::TABLE_NAME);
//        }
        $desc = [];
        try {
            $desc = $this->connection->describeTable($tableName); // information schema
        } catch (\Exception $exception) {

        }
        $cont1 = [];
//        $cont2 = [];

        foreach ($desc as $item) {
            $tmp1 = [
                'column_name' => $item["COLUMN_NAME"],
                'column_type' => $item["DATA_TYPE"],
                'null' => $item["NULLABLE"],
                'primary' => $item["PRIMARY"],
                'old_column_name' => $item["COLUMN_NAME"],
                'old_column_type' => $item["DATA_TYPE"],
                'old_null' => $item["NULLABLE"],
                'old_primary' => $item["PRIMARY"]
            ];
            $cont1[] = $tmp1;
        }

        return [
            $tableName => [
                'old_table_name' => $tableName,
                'table_name' => $tableName,
                'dynamic_rows_container' => $cont1,
//                'old_dynamic_rows_container' => $cont2
            ]
        ];


//        $select = $this->connection->select()
//            ->from($tableName);
//        $result = $this->connection->fetchAll($select);
//        return [
//            'items' => $result
//        ];
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
    }

}
