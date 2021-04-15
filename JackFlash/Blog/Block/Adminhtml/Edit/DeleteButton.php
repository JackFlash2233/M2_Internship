<?php


namespace JackFlash\Blog\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getReviewId()) {
            $data = [
                'label' => __('Delete Article'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this article ?')
                    . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['entity_id' => $this->getReviewId()]) . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }
}
