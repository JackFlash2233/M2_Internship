<?php


namespace MagManager\DBManager\Model;


use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use MagManager\DBManager\Api\Data\NewTableInterface;
use MagManager\DBManager\Api\Data\NewTableSearchResultInterfaceFactory;
use MagManager\DBManager\Api\NewTableRepositoryInterface;
use MagManager\DBManager\Model\ResourceModel\UniversalModel\CollectionFactory;

class NewTableRepository implements NewTableRepositoryInterface
{
    /**
     * @var NewTableModelFactory
     */
    private $tableModelFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var NewTableSearchResultInterfaceFactory
     */
    private $newTableSearchResultInterfaceFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        NewTableModelFactory $tableModelFactory,
        CollectionFactory $collectionFactory,
        NewTableSearchResultInterfaceFactory $newTableSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {

        $this->tableModelFactory = $tableModelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->newTableSearchResultInterfaceFactory = $newTableSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }
    public function save(NewTableInterface $table)
    {
         $table->getResource()->save($table);
        return $table;
    }

    public function getById($id)
    {
        $table = $this->tableModelFactory->create();
        $table->getResource()->load($table, $id);
        if (! $table->getId()) {
            throw new NoSuchEntityException(__('Unable to find article with ID "%1"', $id));
        }
        return $table;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->newTableSearchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    public function delete(NewTableInterface $table)
    {
        $table->getResource()->delete($table);
    }

    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

}
