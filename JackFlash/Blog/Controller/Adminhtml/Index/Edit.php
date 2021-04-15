<?php


namespace JackFlash\Blog\Controller\Adminhtml\Index;

use JackFlash\Blog\Api\ArticleRepositoryInterface;
use JackFlash\Blog\Model\ResourceModel\ArticleFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;

    /**
     * @var ArticleRepositoryInterface
     */
    private $articleRepository;

    public function __construct(
        Context $context,
        ArticleRepositoryInterface $articleRepository,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->articleRepository = $articleRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
