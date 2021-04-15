<?php


namespace JackFlash\Blog\Model;

use JackFlash\Blog\Model\ResourceModel\Article\CollectionFactory;
use JackFlash\Blog\Model\Article;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $loadedData;

    /**
     * @inheritDoc
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $article) {
            $this->loadedData[$article->getId()] = $article->getData();
        }
        return $this->loadedData;
    }
}
