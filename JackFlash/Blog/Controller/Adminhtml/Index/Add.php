<?php


namespace JackFlash\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use JackFlash\Blog\Model\Article;

class Add extends Action
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @inheritDoc
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->context = $context;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('entity_id');
        $rowData = $this->_objectManager->create(Article::class);
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = $rowData->getTitle();
            if (!$rowData->getEntityId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('blog/index/rowdata');
            }
        }

        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Row Data ').$rowTitle : __('Add Row Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('JackFlash_Blog::articles_items'); //
    }
}
