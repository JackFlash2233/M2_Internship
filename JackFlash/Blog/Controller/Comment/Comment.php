<?php


namespace JackFlash\Blog\Controller\Comment;

use JackFlash\Blog\Model\ResourceModel\Comment\Collection;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Comment extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Collection $collection
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->collection = $collection;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
