<?php


namespace JackFlash\Blog\Api;

use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use JackFlash\Blog\Api\Data\CommentInterface;

interface CommentRepositoryInterface
{
    /**
     * Save page.
     *
     * @param CommentInterface $comment
     * @return CommentInterface
     * @throws LocalizedException
     */
    public function save(CommentInterface $comment);

    /**
     * Retrieve page.
     *
     * @param $commentId
     * @return CommentInterface
     * @throws LocalizedException
     */
    public function getById($commentId);

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return PageSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete page.
     *
     * @param CommentInterface $comment
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(CommentInterface $comment);

    /**
     * Delete page by ID.
     *
     * @param $commentId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($commentId);
}
