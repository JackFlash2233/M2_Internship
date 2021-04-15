<?php


namespace JackFlash\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CommentSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get items list.
     *
     * @return \JackFlash\Blog\Api\Data\CommentInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \JackFlash\Blog\Api\Data\CommentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
