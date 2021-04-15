<?php


namespace JackFlash\Blog\Model;

use JackFlash\Blog\Api\Data\EavOptionsInterface;
use JackFlash\Blog\Api\Data\EavOptionsSearchResultInterfaceFactory;
use JackFlash\Blog\Api\EavOptionsRepositoryInterface;
use JackFlash\Blog\Model\ResourceModel\EavOptions\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class EavOptionsRepository implements EavOptionsRepositoryInterface
{
    /**
     * @var EavOptionsFactory
     */
    private $eavOptionsFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var EavOptionsSearchResultInterfaceFactory
     */
    private $searchResultInterfaceFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @inheritDoc
     */
    public function __construct(
        EavOptionsFactory $eavOptionsFactory,
        CollectionFactory $collectionFactory,
        EavOptionsSearchResultInterfaceFactory $searchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->eavOptionsFactory = $eavOptionsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultInterfaceFactory = $searchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(EavOptionsInterface $eavOptions)
    {
        $eavOptions->getResource()->save($eavOptions);
        return $eavOptions;
    }

    /**
     * @inheritDoc
     */
    public function getById($optionId)
    {
        $article = $this->eavOptionsFactory->create();
        $article->getResource()->load($article, $optionId);
        if (!$article->getId()) {
            throw new NoSuchEntityException(__('Unable to find article with ID "%1"', $optionId));
        }
        return $article;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(EavOptionsInterface $eavOptions)
    {
        $eavOptions->getResource()->delete($eavOptions);
    }

    /**
     * @inheritDoc
     */
    public function deleteById($optionId)
    {
        return $this->delete($this->getById($optionId));
    }

    /**
     * @inheritDoc
     */
    public function getByAttributeId($attributeId)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($attributeId, $collection);
        $searchResults = $this->searchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($attributeId);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
