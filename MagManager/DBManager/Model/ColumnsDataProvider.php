<?php


namespace MagManager\DBManager\Model;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\ResourceConnection;

/**
 * Class ColumnsDataProvider
 */
class ColumnsDataProvider extends AbstractDataProvider
{
    const TABLE_NAME1 = 'table_name';
    /**
     * @var Http
     */
    private $request;
    /**
     * @var AdapterInterface
     */
    private $connection;
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * ColumnsDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Http $request
     * @param ResourceConnection $resourceConnection
     * @param CacheInterface $cache
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        Http $request,
        ResourceConnection $resourceConnection,
        CacheInterface $cache,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->request = $request;
        $this->connection = $resourceConnection->getConnection();
        $this->cache = $cache;
    }

    /**
     * @return array[]
     */
    public function getData()
    {
        if (!$this->getCollection()) {
            $this->getCollection();
        }
        return $this->getCollection();
    }

    /**
     * @return array[]
     */
    public function getCollection(): array
    {
        $this->request->getParams();
        $tableName = $this->request->getParam('table_name');

        if (!$tableName) {
            $tableName = $this->cache->load(self::TABLE_NAME1);
        } else {
            $this->cache->save($tableName, self::TABLE_NAME1);
        }

        return [
            'items' => $this->getFields($tableName)
        ];
    }

    /**
     * @param $tableName
     * @return array
     */
    protected function getFields($tableName): array
    {
        $fieldsTable = $this->connection->describeTable($tableName);
//        $test = $this->connection->select()
//            ->from('information_schema.COLUMNS')
//            ->where(new \Zend_Db_Expr('TABLE_NAME = \'' . $tableName . '\''));
//        $res = $this->connection->fetchAll($test);
        $result = [];
        foreach ($fieldsTable as $value) {
            $result[] = $value;
//            $result[] = $value["COLUMN_NAME"];
        }
        return $result;
    }

}
