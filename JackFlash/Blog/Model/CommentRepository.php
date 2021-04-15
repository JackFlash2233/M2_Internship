<?php


namespace JackFlash\Blog\Model;

use JackFlash\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use JackFlash\Blog\Api\CommentRepositoryInterface;
use JackFlash\Blog\Api\Data\CommentInterface;
use JackFlash\Blog\Api\Data\CommentSearchResultInterface;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var CommentFactory
     */
    private $commentFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CommentSearchResultInterface
     */
    private $commentSearchResult;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @inheritDoc
     */
    public function __construct(
        CommentFactory $commentFactory,
        CollectionFactory $collectionFactory,
        CommentSearchResultInterface $commentSearchResult,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->commentFactory = $commentFactory;
        $this->collectionFactory = $collectionFactory;
        $this->commentSearchResult = $commentSearchResult;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(CommentInterface $comment)
    {
        $comment->getResource()->save($comment);
        return $comment;
    }

    /**
     * @inheritDoc
     */
    public function getById($commentId)
    {
        $comment = $this->commentFactory->create();
        $comment->getResource()->load($comment, $commentId);
        if (! $comment->getId()) {
            throw new NoSuchEntityException(__('Unable to find comment with ID "%1"', $commentId));
        }
        return $comment;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->commentSearchResult->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(CommentInterface $comment)
    {
        $comment->getResource()->delete($comment);
    }

    /**
     * @inheritDoc
     */
    public function deleteById($commetId)
    {
        return $this->delete($this->getById($commetId));
    }
}
