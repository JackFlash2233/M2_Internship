<?php


namespace JackFlash\Blog\Api\Data;

use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface EavOptionsSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get items list.
     *
     * @return \JackFlash\Blog\Api\Data\EavOptionsSearchResultInterface|PageSearchResultsInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \JackFlash\Blog\Api\Data\EavOptionsSearchResultInterface|PageSearchResultsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
