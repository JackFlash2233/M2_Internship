<?php


namespace JackFlash\Blog\Plugin;

use JackFlash\Blog\Api\EavOptionsRepositoryInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Framework\App\Rss\UrlBuilderInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;

class AfterGetAllOptins
{
    /**
     * @var EavOptionsRepositoryInterface
     */
    private $optionsRepository;
    /**
     * @var UrlInterface
     */
    private $urlBuilder;


    /**
     * @inheritDoc
     */
    public function __construct(
        EavOptionsRepositoryInterface $optionsRepository,
        UrlInterface $urlBuilder
//        UrlBuilderInterface $urlBuilder

    )
    {
        $this->optionsRepository = $optionsRepository;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param Table $subject
     * @param $result
     * @param bool $withEmpty
     * @param bool $defaultValues
     */
    public function afterGetAllOptions(Table $subject, $result, $withEmpty = true, $defaultValues = false)
    {
        if ($this->urlBuilder->getData('route_name') == 'catalog') {
            $newValues = $result;
            foreach ($newValues as $key => $item) {
                $optionId = $item['value'];
                if ($optionId) {
                    $options = $this->optionsRepository->getById($optionId);
                    $isEnabled = $options->getIsEnabled();
                    if ($isEnabled != 1) {
                        unset($newValues[$key]);
                    }
                }
            }
            return $newValues;
        } else return $result;

    }
}
