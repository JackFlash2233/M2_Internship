<?php
//
//
//namespace JackFlash\Blog\Model\ResourceModel\Total;
//
//use Magento\Catalog\Model\Product;
//use Magento\Catalog\Model\ProductRepository;
//use Magento\Framework\App\Config\ScopeConfigInterface;
//use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
//use Magento\Quote\Model\Quote;
//use Magento\Quote\Api\Data\ShippingAssignmentInterface;
//use Magento\Quote\Model\Quote\Address\Total;
//use Magento\Store\Model\ScopeInterface;
//
//
//class CustomTotal extends AbstractTotal
//{
//    const XML_PATH_DISCOUNT_AMOUNT_VALUE = 'sales/custom_discount/value';
//    const XML_PATH_SKU_VALUE = 'sales/sku/value';
//    /**
//     * @var ScopeConfigInterface
//     */
//    private $scopeConfig;
//
//    /**
//     * @var ProductRepository
//     */
//    private $productRepository;
//
//
//    /**
//     * @inheritDoc
//     */
//    public function __construct(
//        ScopeConfigInterface $scopeConfig,
//        ProductRepository $productRepository
////        \Magento\Framework\Data\Form\FormKey $formKey
//    )
//    {
//        $this->scopeConfig = $scopeConfig;
//        $this->productRepository = $productRepository;
////        $this->formKey = $formKey;
//    }
//
//
//    /**
//     * @param Quote $quote
//     * @param ShippingAssignmentInterface $shippingAssignment
//     * @param Total $total
//     * @return $this
//     */
//    public function collect(
//        Quote $quote,
//        ShippingAssignmentInterface $shippingAssignment,
//        Total $total
//    )
//    {
//        parent::collect($quote, $shippingAssignment, $total);
//
////
//////        $items = $shippingAssignment->getItems();
////
////        $items = $quote->getItems();
////
////        $aId = 41;
////
////        $entity_ids = [];
////
////        $sku = $this->getSkuValue();
////        $discount = $this->getDiscountValue();
////        $freeProduct = $this->productRepository->get($sku);
////        $freeProduct->setPrice(0);
////        $freeProduct->setQty(1);
////        $totalPrice = 0;
////        $items = $quote->getItems();
////        if (!count($items)) {
////            return $this;
////        }
////
////        foreach ($items as $item) {
////            if ($item != $freeProduct) {
////                $categoryIds = $item->getProduct()->getCategoryIds();
////                foreach ($categoryIds as $id) {
////                    if ($id = $aId) {
////                        array_push($entity_ids, $item->getProductId());
////                        $totalPrice += $this->calsDisc($item);
////                    }
////                }
////            }
////            if ($totalPrice >= $discount)
////            {
////                $quote->addProduct($freeProduct);
////                $quote->save();
////            }
////        }
////
////        $tmp = $this->total;
////
//////        if ($totalPrice >= $discount) {
//////
////////            if (!in_array($freeProduct->getId(), $entity_ids)) {
////////                $quote->addProduct($freeProduct);
////////                $quote->save();
//////////                $quote->collectTotals()->save();
////////            }
//////        }
////
////        return $this;
//
//
////        $discount = 0.1 * $quote->getGrandTotal();
////        $total->addTotalAmount($this->getCode(), -$discount);
////        $total->addBaseTotalAmount($this->getCode(), -$discount);
////        $quote->setDiscount($discount);
////        return $this;
//    }
//
//    /**
//     * @param Quote $quote
//     * @param Total $total
//     * @return array
//     */
//    public function fetch(Quote $quote, Total $total)
//    {
////        $discount = $this->getDiscountValue();
//        return [
//            'code' => $this->getCode(),
//            'title' => $this->getLabel(),
//            'value' => 'some value'
//        ];
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getDiscountValue()
//    {
//        $storeScope = ScopeInterface::SCOPE_STORE;
//        return $this->scopeConfig->getValue(self::XML_PATH_DISCOUNT_AMOUNT_VALUE, $storeScope);
//
//    }
//
//    public function getSkuValue()
//    {
//        $storeScope = ScopeInterface::SCOPE_STORE;
//        return $this->scopeConfig->getValue(self::XML_PATH_SKU_VALUE, $storeScope);
//
//    }
//
//    public function calsDisc($item)
//    {
//        $price = $item->getPrice();
//        $qty = $item->getQty();
//        return $qty * $price;
////        if ($price * $qty >= $discount) {
////            return true;
////        } else return false;
//    }
//
//
//}
