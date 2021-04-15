<?php


namespace JackFlash\Blog\Model;

use JackFlash\Blog\Api\Data\ArticleInterface;
use Magento\Framework\Model\AbstractModel;

class Article extends AbstractModel implements ArticleInterface
{
    protected function _construct()
    {
        $this->_init(\JackFlash\Blog\Model\ResourceModel\Article::class);
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
    public function getTitle()
    {
        return parent::getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
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
    public function getStatus()
    {
        return parent::getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
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

    /**
     * @inheritDoc
     */
    public function getUrl()
    {
        return parent::getData(self::URL);
    }

    /**
     * @inheritDoc
     */
    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }
}
