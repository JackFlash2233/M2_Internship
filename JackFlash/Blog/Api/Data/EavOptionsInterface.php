<?php


namespace JackFlash\Blog\Api\Data;

interface EavOptionsInterface
{
    const OPTION_ID = 'option_id';
    const ATTRIBUTE_ID = 'attribute_id';
    const SORT_ORDER = 'sort_order';
    const IS_ENABLED = 'is_enabled';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $optionId
     * @return mixed
     */
    public function setId($optionId);

    /**
     * @return mixed
     */
    public function getAttributeId();

    /**
     * @param $attributeId
     * @return mixed
     */
    public function setAttributeId($attributeId);

    /**
     * @return mixed
     */
    public function getSortOrder();

    /**
     * @param $sortOrder
     * @return mixed
     */
    public function setSortOrder($sortOrder);

    /**
     * @return mixed
     */
    public function getIsEnabled();

    /**
     * @param $isEnabled
     * @return mixed
     */
    public function setIsEnabled($isEnabled);
}
