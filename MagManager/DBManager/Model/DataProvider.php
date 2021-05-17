<?php


namespace MagManager\DBManager\Model;

use Magento\Framework\Setup\Declaration\Schema\Db\MySQL\DbSchemaReader;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var DbSchemaReader
     */
    private $dbSchemaReader;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DbSchemaReader $dbSchemaReader
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        DbSchemaReader $dbSchemaReader,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->dbSchemaReader = $dbSchemaReader;
    }

    /**
     * @return array[]
     */
    public function getCollection(): array
    {
        $data = $this->dbSchemaReader->readTables('default');
        $data = $this->validateData($data);
        return [
            'items' => $data
        ];
    }

    /**
     * @return array[]
     */
    public function getData(): array
    {
        if (!$this->getCollection()) {
            $this->getCollection();
        }
        return $this->getCollection();
    }

    /**
     * @param $data
     * @return array
     */
    public function validateData($data): array
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = ['table_name' => $item];
        }
        return $result;
    }

}
