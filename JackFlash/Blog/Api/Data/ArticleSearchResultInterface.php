<?php


namespace JackFlash\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ArticleSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get items list.
     *
     * @return \JackFlash\Blog\Api\Data\ArticleInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \JackFlash\Blog\Api\Data\ArticleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
