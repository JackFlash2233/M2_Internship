<?php


namespace JackFlash\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use JackFlash\Blog\Model\ResourceModel\EavOptions\CollectionFactory;

class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Data constructor.
     * @param Context $context
     * @param CollectionFactory $collection
     */
    public function __construct(
        Context $context,
        CollectionFactory $collection
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collection;
    }

    /**
     * @return array
     */
    public function getUrlList(): array
    {
        $result = [];
        foreach ($this->collectionFactory
                     ->create()
                     ->addFieldToSelect('entity_id')
                     ->addFieldToSelect('url') as $item) {
            $result += [$item->getData('url') => $item->getData('entity_id')];
        }
        return $result;
    }
}
