<?php


namespace MagManager\DBManager\Model;

use Magento\Developer\Model\Setup\Declaration\Schema\WhitelistGenerator;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Exception\ConfigurationMismatchException;

/**
 * Class DbSchema
 */
class DbSchema
{
    const DB_SCHEMA = '/var/www/html/app/code/MagManager/DBManager/etc/db_schema.xml';
    const DB_SCHEMA_WHITELIST = '/var/www/html/app/code/MagManager/DBManager/etc/db_schema_whitelist.json';
    const MODULE_NAME = 'MagManager_DBManager';
    /**
     * @var WhitelistGenerator
     */
    private $whitelistGenerator;
    /**
     * @var AdapterInterface
     */
    private $connection;

    /**
     * DbSchema constructor.
     * @param ResourceConnection $resourceConnection
     * @param WhitelistGenerator $whitelistGenerator
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        WhitelistGenerator $whitelistGenerator
    )
    {
        $this->connection = $resourceConnection->getConnection();
        $this->whitelistGenerator = $whitelistGenerator;
    }

    /**
     * @param $tableName
     * @param $comment
     */
    public function createDb($tableName, $comment)
    {
        $this->generateTable($tableName, $comment);
        $this->generateWhiteList();
    }

    /**
     * @param $tableName
     * @param $comment
     */
    public function upgradeDB($tableName, $comment)
    {
        if (!$this->searchTable($tableName)) {
            $this->generateTable($tableName, $comment);
        }
        $this->trimArray($tableName);
        $this->generateTable($tableName, $comment);
        $this->generateWhiteList();

    }

    /**
     * @param $tableName
     */
    public function deleteDB($tableName)
    {
        if (!$this->searchTable($tableName)) {
            $comment = $this->getTableComment($tableName);
            $this->generateTable($tableName, $comment);
        }
        $this->trimArray($tableName);
        $this->generateWhiteList();
    }

    /**
     * @param $tableName
     */
    protected function trimArray($tableName)
    {
        $file = file(self::DB_SCHEMA);
        $check = '<table name="' . $tableName . '"';
        $lineNum = 0;
        foreach ($file as $key => $value) {
            if (str_contains($value, $check)) {
                $lineNum = $key;
            }
        }
        $firstPart = array_slice($file, 0, $lineNum);
        $lastPart = array_slice($file, $lineNum);
        $length = 0;
        foreach ($lastPart as $key => $value) {
            if (str_contains($value, '</' . 'table>' . "\n")) {
                $length = $key;
                break;
            }
        }
        $lastPart = array_slice($lastPart, $length + 1);
        $content = array_merge($firstPart, $lastPart);
        file_put_contents(self::DB_SCHEMA, $content);
    }

    /**
     * @param $tableName
     * @param $comment
     */
    protected function generateTable($tableName, $comment)
    {
        $desc = $this->connection->describeTable($tableName);
        $descT = $this->connection->select()
            ->from('information_schema.tables', ['TABLE_NAME', 'TABLE_COMMENT'])
            ->where('table_schema = \'magento2\'  and   TABLE_NAME = \'' . $tableName . '\'');
        $descC = $this->connection->select()
            ->from('information_schema.COLUMNS')
            ->where('TABLE_NAME = \'' . $tableName . '\'');
        $res1 = $this->connection->fetchAll($descT);
        $res2 = $this->connection->fetchAll($descC);
        $columns = array_keys($desc);
        $file = file(self::DB_SCHEMA);
        $lineNum = count($file) - 1;
        unset($file[$lineNum]);
        $firstLine = "\n" . '<table name="' . $tableName . '" resource="default" engine="innodb" comment="' . $comment . '">' . "\n";
        $tmpArray[] = $firstLine;
        foreach ($columns as $column) {
            $columnName = $desc[$column]["COLUMN_NAME"];
            $columnType = $desc[$column]["DATA_TYPE"];
            ($desc[$column]["NULLABLE"]) ? $nullable = 'true' : $nullable = 'false';
            $column = "<column xsi:type=\"" . $columnType . "\" name=\"" . $columnName . "\" nullable=\"" . $nullable . "\" comment=\"test\"" . "/>" . "\n";

            // xsi:type :
//            blob (includes blob, mediumblob, longblob)
//            boolean
//            date
//            datetime
//            decimal
//            float
//            int (includes smallint, bigint, tinyint)
//            json
//            real (includes decimal, float, double, real)
//            smallint
//            text (includes text, mediumtext, longtext)
//            timestamp
//            varbinary
//            varchar

//            if ($desc[$column]["DATA_TYPE"] == 'smallint' or bigint or tinyint) data_type =  int
//            -//- == includes decimal, float, double, real data_type = real
//            -//-  ==  (includes text, mediumtext, longtext) text

            $tmpArray[] = $column;
        }
        $lastLine = '</' . 'table>' . "\n";
        $tmpArray[] = $lastLine;
        $tmpArray[] = '</' . 'schema>';

        foreach ($tmpArray as $value) {
            $file[] = $value;
        }
        $content = implode('', $file);
        file_put_contents(self::DB_SCHEMA, $content);
    }

    protected function generateWhiteList()
    {
        try {
            $this->whitelistGenerator->generate(self::MODULE_NAME);
        } catch (ConfigurationMismatchException $e) {
        }
    }

    /**
     * @param $tableName
     * @return bool
     */
    public function searchTable($tableName): bool
    {
        $file = file(self::DB_SCHEMA);
        $check = '<table name="' . $tableName . '"';
        $f = false;
        foreach ($file as $key => $value) {
            if (str_contains($value, $check)) {
                $f = true;
            }
        }
        return $f;
    }
    /**
     * @param $tableName
     * @return mixed
     */
    public function getTableComment($tableName)
    {
        $descC = $this->connection->select()
            ->from('information_schema.COLUMNS')
            ->where('TABLE_NAME = \'' . $tableName . '\'');
        $res2 = $this->connection->fetchAll($descC);
        return $res2[0]["COLUMN_COMMENT"];

    }
}
