<?php


namespace MagManager\DBManager\Model;


use Magento\Framework\Api\Filter;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class NameDataProvider
 */
class NameDataProvider extends AbstractDataProvider
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
     * @var DbSchema
     */
    private $dbSchema;

    /**
     * NameDataProvider constructor.
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
        DbSchema $dbSchema,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->request = $request;
        $this->connection = $resourceConnection->getConnection();
        $this->cache = $cache;
        $this->dbSchema = $dbSchema;
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
        $tableName = $this->request->getParam('table_name');
        if (!$tableName) {
            $tableName = $this->cache->load(self::TABLE_NAME);
        } else {
            $this->cache->save($tableName, self::TABLE_NAME);
        }
        $comment = $this->dbSchema->getTableComment($tableName);

        return [
            null => [
                'table_name' => $tableName,
                'table_comment' => $comment
            ]];
    }

    /**
     * @param Filter $filter
     * @return mixed|void
     */
    public function addFilter(Filter $filter)
    {
    }
}
