<?php


namespace JackFlash\Blog\Api;

use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use JackFlash\Blog\Api\Data\ArticleInterface;

interface ArticleRepositoryInterface
{
    /**
     * Save page.
     *
     * @param ArticleInterface $article
     * @return ArticleInterface
     * @throws LocalizedException
     */
    public function save(ArticleInterface $article);

    /**
     * Retrieve page.
     *
     * @param $articleId
     * @return ArticleInterface
     * @throws LocalizedException
     */
    public function getById($articleId);

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
     * @param ArticleInterface $article
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(ArticleInterface $article);

    /**
     * Delete page by ID.
     *
     * @param $articleId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($articleId);
}
