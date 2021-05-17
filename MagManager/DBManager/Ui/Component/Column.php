<?php


namespace MagManager\DBManager\Ui\Component;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns;
use MagManager\DBManager\Ui\Component\Listing\Column\CustomColumnCreator;

/**
 * Class Column
 */
class Column extends Columns
{
    /**
     * @var CustomColumnCreator
     */
    private $columnCreator;

    /**
     * Column constructor.
     * @param ContextInterface $context
     * @param CustomColumnCreator $columnCreator
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        CustomColumnCreator $columnCreator,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $components, $data);
        $this->columnCreator = $columnCreator;
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
     * @return string[]
     */
    public function getFields(): array
    {
        return [
            'SCHEMA_NAME' => 'SCHEMA_NAME',
            'TABLE_NAME' => 'TABLE_NAME',
            "COLUMN_NAME" => "COLUMN_NAME",
            "COLUMN_POSITION" => "COLUMN_POSITION",
            "DATA_TYPE" => "DATA_TYPE",
            "DEFAULT" => "DEFAULT",
            "NULLABLE" => "NULLABLE",
            "LENGTH" => "LENGTH",
            "SCALE" => "SCALE",
            "PRECISION" => "PRECISION",
            "UNSIGNED" => "UNSIGNED",
            "PRIMARY" => "PRIMARY",
            "PRIMARY_POSITION" => "PRIMARY_POSITION",
            "IDENTITY" => "IDENTITY"
        ];
    }
}
