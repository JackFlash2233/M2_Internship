<?php


namespace JackFlash\Blog\Model\ResourceModel\Source;

use Magento\Config\Model\Config\Source\Yesno;

class CarsModel extends Yesno
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Toyota')],
            ['value' => 2, 'label' => __('Honda')],
            ['value' => 3, 'label' => __('VW')],
            ['value' => 4, 'label' => __('Audi')],
            ['value' => 5, 'label' => __('ZAZ')],
        ];
    }
}
