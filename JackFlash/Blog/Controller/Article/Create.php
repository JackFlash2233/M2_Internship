<?php


namespace JackFlash\Blog\Controller\Article;

use JackFlash\Blog\Model\ResourceModel\ArticleFactory;
use JackFlash\Blog\Model\ArticleRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Create extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var ArticleFactory
     */
    private $articleFactory;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(
        Context $context,
        ArticleFactory  $articleFactory,
        ArticleRepository $articleRepository
    ) {
        parent::__construct($context);
        $this->articleFactory = $articleFactory;
        $this->articleRepository = $articleRepository;
    }

    public function execute()
    {
        $resultArticle = $this->articleFactory->create();
        $data = [
            'author' => $this->_request->getParam('author'),
            'title' => $this->_request->getParam('title'),
            'description' => $this->_request->getParam('description'),
            'content' => $this->_request->getParam('content'),
            'status' => $this->_request->getParam('status'),
            'enabled' => $this->_request->getParam('enabled')
        ];

        $resultArticle->setData($data);
        $this->articleRepository->save($resultArticle);
        $url = $this->_redirect->getRefererUrl();
        $this->_redirect($url);
    }
}
