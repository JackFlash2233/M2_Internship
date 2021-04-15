<?php


namespace JackFlash\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Article extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('blog_blog_articles', 'entity_id');
    }
}
