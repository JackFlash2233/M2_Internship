<?php


namespace MagManager\DBManager\Block\Adminhtml\DBManager\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    const COLUMN_NAME = 'COLUMN_NAME';
    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(
        Context $context,
        Registry $registry,
        CacheInterface $cache
    )
    {
        parent::__construct($context, $registry);
        $this->cache = $cache;
    }

    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $this->cache->remove(self::COLUMN_NAME);
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href= '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
