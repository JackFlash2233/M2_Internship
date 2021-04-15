<?php


namespace JackFlash\Blog\Controller\Comment;

use JackFlash\Blog\Model\ResourceModel\CommentFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;

class Create extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    private $commentFactory;

    public function __construct(
        Context $context,
        RequestInterface $request,
        CommentFactory $commentFactory
    ) {
        parent::__construct($context);
        $this->request = $request;
        $this->commentFactory = $commentFactory;
    }

    public function execute()
    {
        $resultComment = $this->commentFactory->create();
        $data = [
            'article_id' => $this->getRequest()->getParam('article_id'),
            'author' => $this->getRequest()->getParam('author'),
            'content' => $this->getRequest()->getParam('content'),
            'enabled' => $this->getRequest()->getParam('enabled')
        ];
        $resultComment->setData($data);
        $resultComment->save();

        $this->_redirect('blog/comment/comment');
    }
}
