<?php


namespace MagManager\DBManager\Block\Adminhtml\DBManager\Edit;


use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveColumnButton
 */
class SaveColumnButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $url = $this->getUrl('dbmanager/index/savecolumn');
        return [
            'label' => __('Save Column'),
            'class' => 'save primary',
            'on_click' => "setLocation('". $url ."'')",
            'sort_order' => 90,
        ];
    }
}
