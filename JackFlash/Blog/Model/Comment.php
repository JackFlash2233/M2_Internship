<?php


namespace JackFlash\Blog\Model;

use Magento\Framework\Model\AbstractModel;
use JackFlash\Blog\Api\Data\CommentInterface;

class Comment extends AbstractModel implements CommentInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Comment::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getAricleId()
    {
        return parent::getData(self::ARTICLE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setArticleId($articleId)
    {
        return $this->setData(self::ARTICLE_ID, $articleId);
    }

    /**
     * @inheritDoc
     */
    public function getAuthor()
    {
        return parent::getData(self::AUTHOR);
    }

    /**
     * @inheritDoc
     */
    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }

    /**
     * @inheritDoc
     */
    public function getContent()
    {
        return parent::getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritDoc
     */
    public function getEnabled()
    {
        return parent::getData(self::ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setEnabled($enabled)
    {
        return $this->setData(self::ENABLED, $enabled);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return parent::getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
