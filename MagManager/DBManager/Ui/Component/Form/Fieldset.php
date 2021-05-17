<?php


namespace MagManager\DBManager\Ui\Component\Form;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Ui\Component\Form\FieldFactory;
use Magento\Ui\Component\Form\Fieldset as BaseFieldset;

class Fieldset extends BaseFieldset
{
    /**
     * @var FieldFactory
     */
    private $fieldFactory;

    public function __construct(
        ContextInterface $context,
        FieldFactory $fieldFactory,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $components, $data);
        $this->fieldFactory = $fieldFactory;
    }

    /**
     * @return array
     */
    public function getChildComponents(): array
    {
        $options = [
            0 => [
                'label' => 'CHAR',
                'value' => 'CHAR'
            ],
            1 => [
                'label' => 'INT',
                'value' => 'INT'
            ],
            2 => [
                'label' => 'BOOL',
                'value' => 'BOOL'
            ],
            3 => [
                'label' => 'CHAR',
                'value' => 'CHAR'
            ],
            4 => [
                'label' => 'TEXT',
                'value' => 'TEXT'
            ]
        ];
        $null = [
            0 => [
                'label' => 'NULL',
                'value' => 'NULL'
            ],
            1 => [
                'label' => 'NOT NULL',
                'value' => 'NOT NULL'
            ]
        ];
        $fields = [
            [
                'label' => __('Column Name'),
                'value' => __('Column Name'),
                'formElement' => 'input',
            ],
            [
                'label' => __('Column Type'),
                'value' => $options,
                'formElement' => 'select',
            ],
            [
                'label' => __('NULL or NOT NULL'),
                'value' => $null,
                'formElement' => 'select',
            ]
        ];

        foreach ($fields as $key => $fieldConfig) {
            $fieldInstance = $this->fieldFactory->create();
            $name = 'table_columns_' . $key;

            $fieldInstance->setData(
                [
                    'config' => $fieldConfig,
                    'name' => $name
                ]
            );

            $fieldInstance->prepare();
            $this->addComponent($name, $fieldInstance);
        }

        return parent::getChildComponents();
    }
}
