<?php


namespace MagManager\DBManager\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface NewTableSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return NewTableInterface[]
     */
    public function getItems();

    /**
     * @param NewTableInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
