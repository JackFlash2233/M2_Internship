<?php


namespace MagManager\DBManager\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class NullOrNOTNull
 */
class NullOrNOTNull implements OptionSourceInterface
{
    /**
     * @return \string[][]
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => 'NULL',
                'value' => 'true',
            ],
            [
                'label' => 'NOT NULL',
                'value' => 'false',
            ]
        ];
    }
}
