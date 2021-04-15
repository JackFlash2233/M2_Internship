<?php


namespace JackFlash\Blog\Plugin;

use JackFlash\Blog\Api\EavOptionsRepositoryInterface;
use Magento\Catalog\Controller\Adminhtml\Product\Attribute\Save;
use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Serialize\Serializer\FormData;

class AfterSavePlugin
{
    /**
     * @var FormData|null
     */
    private $formDataSerializer;
    /**
     * @var EavOptionsRepositoryInterface
     */
    private $eavOptionsRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var Attribute
     */
    private $eavAttribute;

    /**
     * AfterSavePlugin constructor.
     * @param FormData $formDataSerializer
     * @param EavOptionsRepositoryInterface $eavOptionsRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Attribute $eavAttribute
     */
    public function __construct(
        FormData $formDataSerializer,
        EavOptionsRepositoryInterface $eavOptionsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Attribute $eavAttribute
    )
    {
        $this->formDataSerializer = $formDataSerializer;
        $this->eavOptionsRepository = $eavOptionsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->eavAttribute = $eavAttribute;
    }

    /**
     * @param Save $subject
     * @param $result
     */
    public function afterExecute(Save $subject, $result)
    {
        $data = $this->formDataSerializer->unserialize($subject->getRequest()->getParam('serialized_options', '[]'));
        if (!$data) {
            return $result;
        }
        $attributeId = $subject->getRequest()->getParam('attribute_id');
        if (!$attributeId) {
            $attributeCode = $this->labelToCode($subject->getRequest()->getPost('frontend_label')[0]);
            $attributeId = $this->eavAttribute->getIdByCode('catalog_product', $attributeCode);
        }
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('attribute_id', $attributeId)
            ->create();
        $searchResult = $this->eavOptionsRepository->getList($searchCriteria);
        $optionIds = [];
        $searchResultItems = $searchResult->getItems();

        foreach ($searchResultItems as $item) {
            $optionIds[] = (int)$item->getOptionId();
        }
        $options = $this->isDeleted($data["option"]);
        $sortedArray = $this->sortIsEnabled($options, $optionIds);
        foreach (array_keys($sortedArray) as $key) {
            $tmp = $this->eavOptionsRepository->getById($key);
            $tmp->setIsEnabled($sortedArray[$key]);
            $this->eavOptionsRepository->save($tmp);
        }
        return $result;
    }

    public function labelToCode($label): string
    {
        return strtolower(str_replace(" ", "_", trim($label)));
    }

    public function sortIsEnabled($options, $optionIds)
    {
        ksort($options, SORT_NUMERIC);
        $str = 0;
        foreach ($options as $key => $item) {
            if (is_string($key)) {
                $str++;
            }
        }
        $tmpArray = [];
        if ($str > 0) {
            for ($i = 0; $i < $str; $i++) {
                $tmpArray[] = array_shift($options);
            }
            $options = array_merge($options, $tmpArray);
        }
        return array_combine($optionIds, $options);
    }

    public function isDeleted($options)
    {
        $del = $options["delete"];
        $enb = $options["isEnabled"];
        foreach ($del as $key => $item) {
            if ($item == 1) {
                unset($del[$key]);
            }
        }
        return array_intersect_key($enb, $del);
    }
}
