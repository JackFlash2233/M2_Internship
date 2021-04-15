<?php

namespace JackFlash\Blog\Block\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Phrase;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use JackFlash\Blog\Api\EavOptionsRepositoryInterface;
use JackFlash\Blog\Api\Data\EavOptionsInterface;

class Attributes extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Product
     */
    protected $_product = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;
    /**
     * @var EavOptionsRepositoryInterface
     */
    private $eavOptionsRepository;
    /**
     * @var EavOptionsInterface
     */
    private $eavOptions;
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    private $connection;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        PriceCurrencyInterface $priceCurrency,
        EavOptionsRepositoryInterface $eavOptionsRepository,
        EavOptionsInterface $eavOptions,
        ResourceConnection $resourceConnection,
        array $data = []
    ) {
        $this->priceCurrency = $priceCurrency;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
        $this->eavOptionsRepository = $eavOptionsRepository;
        $this->eavOptions = $eavOptions;
        $this->connection = $resourceConnection->getConnection();
    }

    /**
     * Returns a Product
     *
     * @return Product
     */
    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }
        return $this->_product;
    }

    /**
     * @param $optionId
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getIsEnabled($optionId)
    {
        $attData = $this->eavOptionsRepository->getById($optionId);
        return $attData->getIsEnabled();
    }

    public function getOptionValue($optionId)
    {
        $eaov = $this->connection->getTableName('eav_attribute_option_value');

        $select = $this->connection->select()
            ->from(
                $eaov,
                'value'
            )
            ->where('option_id = ' . $optionId);
        return $this->connection->fetchAll($select);
    }

    /**
     * $excludeAttr is optional array of attribute codes to exclude them from additional data array
     *
     * @param array $excludeAttr
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAdditionalData(array $excludeAttr = [])
    {
        $data = [];
        $product = $this->getProduct();
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($this->isVisibleOnFrontend($attribute, $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                if ($value instanceof Phrase) {
                    $value = (string)$value;
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = $this->priceCurrency->convertAndFormat($value);
                }

                if (is_string($value) && strlen(trim($value))) {
                    $data[$attribute->getAttributeCode()] = [
                        'label' => $attribute->getStoreLabel(),
                        'value' => $value,
                        'code' => $attribute->getAttributeCode(),
                    ];
                }
            }
        }
        return $data;
    }

    /**
     * Determine if we should display the attribute on the front-end
     *
     * @param \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute
     * @param array $excludeAttr
     * @return bool
     * @since 103.0.0
     */
    protected function isVisibleOnFrontend(
        \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute,
        array $excludeAttr
    ) {
        return ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr));
    }
}
