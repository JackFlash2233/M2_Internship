<?php


namespace MagManager\DBManager\Block\Adminhtml\DBManager\Edit;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class EditTableNameButton
 */
class EditTableNameButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $url = $this->getUrl('dbmanager/index/edittablename');
        return [
            'label' => __('Edit Table Name'),
            'on_click' => "setLocation('" . $url . "'')",
            'class' => 'back',
            'sort_order' => 10
        ];
    }
}
