<?php


namespace MagManager\DBManager\Block\Adminhtml\DBManager\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var Http
     */
    private $request;

    /**
     * DeleteButton constructor.
     * @param Context $context
     * @param Registry $registry
     * @param Http $request
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Http $request)
    {
        parent::__construct($context, $registry);
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];

        if ($this->getTableName()) {
            $data = [
                'label' => __('Delete Table'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this table ?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['table_name' => $this->getTableName() ]);
    }

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->request->getParam('table_name');
    }
}
