<?php


namespace JackFlash\Blog\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Context
     */
    private $context;

    /**
     * GenericButton constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->context = $context;
    }

    /**
     * @return int|null
     */
    public function getReviewId()
    {
        return $this->context->getRequest()->getParam('entity_id');
    }

//    public function getId()
//    {
//        $article = $this->registry->registry('article');
//        return $article ? $article->getId() : null;
//    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
