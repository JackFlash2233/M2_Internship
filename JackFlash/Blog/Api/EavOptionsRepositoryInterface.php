<?php


namespace JackFlash\Blog\Api;

use JackFlash\Blog\Api\Data\EavOptionsInterface;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface EavOptionsRepositoryInterface
{
    /**
     * @param EavOptionsInterface $eavOptions
     * @return EavOptionsInterface
     * @throws LocalizedException
     */
    public function save(EavOptionsInterface $eavOptions);

    /**
     * @param $optionId
     * @return EavOptionsInterface
     * @throws LocalizedException
     */
    public function getById($optionId);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PageSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param EavOptionsInterface $eavOptions
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(EavOptionsInterface $eavOptions);

    /**
     * @param $optionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($optionId);

    /**
     * @param $attributeId
     * @return mixed
     */
    public function getByAttributeId($attributeId);
}
