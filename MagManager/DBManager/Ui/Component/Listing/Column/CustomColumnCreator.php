<?php


namespace MagManager\DBManager\Ui\Component\Listing\Column;


use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponentInterface;

class CustomColumnCreator
{
    /**
     * @var UiComponentFactory
     */
    private $componentFactory;

    public function __construct(
        UiComponentFactory $componentFactory
    )
    {
        $this->componentFactory = $componentFactory;
    }

    public function addColumn(
        $context,
//        UiComponentInterface $existingColumn,
        $columnName,
        $label
//        $sortOrder
    )
    {
//        $config = $existingColumn->getConfiguration();
        $config['label'] = $label;

        $arguments = [
            'data' => [
                'config' => $config,
//                'sortOrder' => $sortOrder
            ],
            'context' => $context,
        ];

        return $this->componentFactory->create($columnName, 'column', $arguments);
    }

}
