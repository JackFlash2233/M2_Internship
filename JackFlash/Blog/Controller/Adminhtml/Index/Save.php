<?php


namespace JackFlash\Blog\Controller\Adminhtml\Index;

use Exception;
use JackFlash\Blog\Model\ArticleFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\Session;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Index';

    protected $resultPageFactory;
    protected $articleFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ArticleFactory $articleFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->articleFactory = $articleFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $article = $this->articleFactory->create();
                $article->setData($data['article']);
                $article->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get(Session::class)->setFormData(false);
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get(Session::class)->setFormData($data);
                if (isset($article)) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $article->getId()]);
                }
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
