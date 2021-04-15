<?php


namespace JackFlash\Blog\Controller\Adminhtml\Index;

use JackFlash\Blog\Api\ArticleRepositoryInterface;
use JackFlash\Blog\Model\ResourceModel\Article;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class MassDelete extends Action
{
    /**
     * @var Article|Context
     */
    /**
     * @var ArticleRepositoryInterface|Context
     */
    private $articleRepository;

    /**
     * @inheritDoc
     */
    public function __construct(
        Context $context,
        ArticleRepositoryInterface $articleRepository
    ) {
        parent::__construct($context);
        $this->articleRepository = $articleRepository;
    }

    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);
        if (!is_array($ids) || !count($ids)) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }
        foreach ($ids as $id) {
            if ($article = $this->articleRepository->getById($id)) {
                $this->articleRepository->deleteById($id);
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', count($ids)));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
