<?php

namespace JackFlash\Blog\Controller;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use JackFlash\Blog\Helper\Data;

class Router implements RouterInterface
{
    /**
     * @var Data
     */
    private $helperData;

    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * Router constructor.
     * @param ActionFactory $actionFactory
     * @param ManagerInterface $eventManager
     * @param UrlInterface $url
     * @param PageFactory $pageFactory
     * @param StoreManagerInterface $storeManager
     * @param ResponseInterface $response
     * @param Data $helperData
     */
    public function __construct(
        ActionFactory $actionFactory,
        ManagerInterface $eventManager,
        UrlInterface $url,
        PageFactory $pageFactory,
        StoreManagerInterface $storeManager,
        ResponseInterface $response,
        Data $helperData
    ) {
        $this->actionFactory = $actionFactory;
        $this->_eventManager = $eventManager;
        $this->_url = $url;
        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_response = $response;
        $this->helperData = $helperData;
    }

    /**
     * @param RequestInterface $request
     * @return false|ActionInterface
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        $parts = explode('/', $identifier);
        if (count($parts) != 2) {
            return false;
        }
        if ($parts[0] != 'blog') {
            return false;
        }
        $id = $this->helperData->getUrlList()[$parts[1]];

        $request->setModuleName('blog')
            ->setControllerName('article')
            ->setActionName('view')
            ->setParam('id', $id);
        //$request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);

        return $this->actionFactory->create(Forward::class);
    }
}
