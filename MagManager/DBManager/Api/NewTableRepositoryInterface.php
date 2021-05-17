<?php


namespace MagManager\DBManager\Api;

use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use MagManager\DBManager\Api\Data\NewTableInterface;

interface NewTableRepositoryInterface
{
    /**
     * Save page.
     *
     * @param NewTableInterface $table
     * @return NewTableInterface
     * @throws LocalizedException
     */
    public function save(NewTableInterface $table);

    /**
     * Retrieve page.
     *
     * @param $id
     * @return NewTableInterface
     * @throws LocalizedException
     */
    public function getById($id);

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
     * @param NewTableInterface $table
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(NewTableInterface $table);

    /**
     * Delete page by ID.
     *
     * @param $id
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($id);

}
