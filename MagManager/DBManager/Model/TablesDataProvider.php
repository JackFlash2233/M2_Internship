<?php


namespace MagManager\DBManager\Model;


use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\ResourceConnection;

/**
 * Class TablesDataProvider
 */
class TablesDataProvider extends AbstractDataProvider
{
    const TABLE_NAME = 'table_name';
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
     * TablesDataProvider constructor.
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
     * @return array
     */
    public function getData(): array
    {
        if (!$this->getCollection()) {
            $this->getCollection();
        }
        return $this->getCollection();
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        $this->request->getParams();
        $tableName = $this->request->getParam('table_name');

        if (!$tableName) {
            $tableName = $this->cache->load(self::TABLE_NAME);
        } else {
            $this->cache->save($tableName, self::TABLE_NAME);
        }

        $select = $this->connection->select()
            ->from($tableName);
        $result = $this->connection->fetchAll($select);
        return [
            'items' => $result
        ];
    }

}
