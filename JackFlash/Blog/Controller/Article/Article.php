<?php


namespace JackFlash\Blog\Controller\Article;

use JackFlash\Blog\Api\ArticleRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Article extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ArticleRepositoryInterface $articleRepository
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->articleRepository = $articleRepository;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
