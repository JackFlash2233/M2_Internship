<?php

namespace JackFlash\Blog\Observer;

use Magento\Checkout\Model\Cart;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartItemInterfaceFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Store\Model\ScopeInterface;
use Magento\Checkout\Model\Session;
use Magento\Quote\Api\Data\CartInterface;

class AddGift implements ObserverInterface
{
    const XML_PATH_DISCOUNT_AMOUNT_VALUE = 'sales/custom_discount/value';
    const XML_PATH_SKU_VALUE = 'sales/sku/value';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var Product
     */
    private $product;
    /**
     * @var CartItemInterfaceFactory
     */
    private $interfaceFactory;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * addGift constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ProductRepository $productRepository
     * @param Product $product
     * @param Cart $cart
     * @param CartItemInterfaceFactory $interfaceFactory
     * @param Session $session
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ProductRepository $productRepository,
        Product $product,
        Cart $cart,
        CartItemInterfaceFactory $interfaceFactory,
        Session $session,
        CartRepositoryInterface $cartRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->cart = $cart;
        $this->product = $product;
        $this->interfaceFactory = $interfaceFactory;
        $this->session = $session;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param Observer $observer
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $aId = 41;
        $sku = $this->getSkuValue();
        $discount = $this->getDiscountValue();
        $freeProduct = $this->productRepository->get($sku);
        $totalPrice = 0;
        $check = false;
        $flagFree = false;
        $items = $observer->getCart()->getQuote()->getAllVisibleItems();

        foreach ($items as $item) {
            if ($item->getSku() == $sku && $item->getPrice() != 0) {
                $check = true;
            }
            if ($item->getSku() == $sku && $item->getPrice() == 0) {
                $flagFree = true;
            }
        }

        foreach ($items as $item) {
            if (!$check) {
                $itemId = $item->getProductId();
                $freeProductId = $freeProduct->getEntityId();
                $itemPrice = $item->getPrice();
                $product = $item->getProduct();

                if ($itemId == $freeProductId && $itemPrice != 0) {
                    $cartItem = $this->interfaceFactory->create();
                    $cartItem->setProduct($product);
                    $quoteId = $this->session->getQuoteId();
                    $cartTest2 = $this->cartRepository->get($quoteId);
                    $cartTest2->addItem($cartItem);
                    $cartTest2->save();
                }
            }
            if ($item != $freeProduct) {
                $categoryIds = $item->getProduct()->getCategoryIds();
                foreach ($categoryIds as $id) {
                    if ($id = $aId) {
                        $totalPrice += $this->calsDisc($item);
                    }
                }
            }
            if ($totalPrice >= $discount) {
                $id = $freeProduct->getId();
                $product1 = $this->product->load($id);
                $ids = $this->cart->getProductIds();
                if ($id != $item->getProductId() && !$flagFree) {
                    $cartItem1 = $this->interfaceFactory->create();
                    $cartItem1->setProduct($product1);
                    $cartItem1->addQty(1);
                    $cartItem1->setCustomPrice(0);
                    $cartItem1->setOriginalCustomPrice(0);
                    $cartItem1->getProduct()->setIsSuperMode(true);
                    $quoteId = $this->session->getQuoteId();
                    $cartTest2 = $this->cartRepository->get($quoteId);
                    $cartTest2->addItem($cartItem1);
                    $cartTest2->collectTotals()->save();
                    $flagFree = true;

                }
            } else {
                $itemId = $item->getProductId();
                $freeProductId = $freeProduct->getEntityId();
                $itemPrice = $item->getPrice();
                if ($itemId == $freeProductId && $itemPrice == 0) { //and $item->getPrice() == 0
                    $this->cart->removeItem($item->getId());
                    $this->cart->save();
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getDiscountValue()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_DISCOUNT_AMOUNT_VALUE, $storeScope);
    }

    /**
     * @return mixed
     */
    public function getSkuValue()
    {
        $storeScope = ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_SKU_VALUE, $storeScope);
    }

    /**
     * @param $item
     * @return float|int
     */
    public function calsDisc($item)
    {
        $price = $item->getPrice();
        $qty = $item->getQty();
        return $qty * $price;
    }
}
