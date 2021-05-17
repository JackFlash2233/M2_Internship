<?php


namespace MagManager\DBManager\Model\Source;


use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class ColumnType
 * @package MagManager\DBManager\Model\Source
 */
class ColumnType implements OptionSourceInterface
{
    /**
     * @return \string[][]
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => 'SMALLINT',
                'value' => 'smallint',
            ],
            [
                'label' => 'INT',
                'value' => 'integer',
            ],
            [
                'label' => 'DECIMAL',
                'value' => 'decimal',
            ],
            [
                'label' => 'TEXT',
                'value' => 'text',
            ],
            [
                'label' => 'DATE',
                'value' => 'date',
            ],
            [
                'label' => 'FLOAT',
                'value' => 'float',
            ],
            [
                'label' => 'BOOLEAN',
                'value' => 'boolean',
            ]
        ];
    }
}
