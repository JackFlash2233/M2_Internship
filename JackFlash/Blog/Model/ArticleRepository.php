<?php


namespace JackFlash\Blog\Model;

use JackFlash\Blog\Api\ArticleRepositoryInterface;
use JackFlash\Blog\Api\Data\ArticleInterface;
use JackFlash\Blog\Api\Data\ArticleSearchResultInterfaceFactory;
use JackFlash\Blog\Model\ResourceModel\EavOptions\CollectionFactory;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var ArticleFactory
     */
    private $articleFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ArticleSearchResultInterfaceFactory
     */
    private $articleSearchResultInterfaceFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        ArticleFactory $articleFactory,
        CollectionFactory $collectionFactory,
        ArticleSearchResultInterfaceFactory $articleSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->articleFactory = $articleFactory;
        $this->collectionFactory = $collectionFactory;
        $this->articleSearchResultInterfaceFactory = $articleSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(ArticleInterface $article)
    {
        $article->getResource()->save($article);
        return $article;
    }

    /**
     * @inheritDoc
     */
    public function getById($articleId)
    {
        $article = $this->articleFactory->create();
        $article->getResource()->load($article, $articleId);
        if (! $article->getId()) {
            throw new NoSuchEntityException(__('Unable to find article with ID "%1"', $articleId));
        }
        return $article;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \JackFlash\Blog\Api\Data\ArticleSearchResultInterface|PageSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->articleSearchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(ArticleInterface $article)
    {
        $article->getResource()->delete($article);
    }

    /**
     * @inheritDoc
     */
    public function deleteById($articleId)
    {
        return $this->delete($this->getById($articleId));
    }
}
