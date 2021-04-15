<?php

namespace JackFlash\Blog\Model\Entity\Attribute\Source;

use JackFlash\Blog\Api\EavOptionsRepositoryInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;

class Table extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    /**
     * Default values for option cache
     *
     * @var array
     */
    protected $_optionsDefault = [];

    /**
     * @var CollectionFactory
     */
    protected $_attrOptionCollectionFactory;

    /**
     * @var OptionFactory
     */
    protected $_attrOptionFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var EavOptionsRepositoryInterface
     */
    private $optionsRepository;

    /**
     * @inheritDoc
     */
    public function __construct(
        CollectionFactory $attrOptionCollectionFactory,
        OptionFactory $attrOptionFactory,
        EavOptionsRepositoryInterface $optionsRepository
    ) {
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
        $this->optionsRepository = $optionsRepository;
    }

    /**
     * Retrieve Full Option values array
     *
     * @param bool $withEmpty Add empty option to array
     * @param bool $defaultValues
     * @return array
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        $storeId = $this->getAttribute()->getStoreId();
        if ($storeId === null) {
            $storeId = $this->getStoreManager()->getStore()->getId();
        }
        if (!is_array($this->_options)) {
            $this->_options = [];
        }
        if (!is_array($this->_optionsDefault)) {
            $this->_optionsDefault = [];
        }
        $attributeId = $this->getAttribute()->getId();
        if (!isset($this->_options[$storeId][$attributeId])) {
            $collection = $this->_attrOptionCollectionFactory->create()->setPositionOrder(
                'asc'
            )->setAttributeFilter(
                $attributeId
            )->setStoreFilter(
                $storeId
            )->load();

            $this->_options[$storeId][$attributeId] = $collection->toOptionArray();
            $this->_optionsDefault[$storeId][$attributeId] = $collection->toOptionArray('default_value');
        }

        $options = $defaultValues
            ? $this->_optionsDefault[$storeId][$attributeId]
            : $this->_options[$storeId][$attributeId];
        if ($withEmpty) {
            $options = $this->addEmptyOption($options);
        }

        $newValues = $options;
        foreach ($newValues as $key => $item) {
            $optionId = $item['value'];
            if ($optionId) {
                $options = $this->optionsRepository->getById($optionId);
                $isEnabled = $options->getIsEnabled();
                if ($isEnabled != 1) {
                    unset($newValues[$key]);
                }
            }
        }
        return $options;
    }

    private function getStoreManager()
    {
        if ($this->storeManager === null) {
            $this->storeManager = ObjectManager::getInstance()->get(StoreManagerInterface::class);
        }
        return $this->storeManager;
    }

    private function addEmptyOption(array $options)
    {
        array_unshift($options, ['label' => ' ', 'value' => '']);
        return $options;
    }
}
