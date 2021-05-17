<?php


namespace MagManager\DBManager\Block\Adminhtml\DBManager\Edit;


use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $url = $this->getUrl('dbmanager/index/savenewtable');
        return [
            'label' => __('Save Table'),
            'class' => 'save primary',
            'on_click' => "setLocation('" . $url . "'')",
            'sort_order' => 90,
        ];
    }
}
