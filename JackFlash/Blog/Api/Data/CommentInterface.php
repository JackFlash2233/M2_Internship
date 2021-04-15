<?php


namespace JackFlash\Blog\Api\Data;

interface CommentInterface
{
    const ENTITY_ID = 'entity_id';
    const ARTICLE_ID = 'article_id';
    const AUTHOR = 'author';
    const CONTENT = 'content';
    const ENABLED = 'enabled';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param $id
     * @return int
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getAricleId();

    /**
     * @param $articleId
     * @return int
     */
    public function setArticleId($articleId);

    /**
     * @return string
     */
    public function getAuthor();

    /**
     * @param $author
     * @return string
     */
    public function setAuthor($author);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param $content
     * @return string
     */
    public function setContent($content);

    /**
     * @return mixed
     */
    public function getEnabled();

    /**
     * @param $enabled
     * @return mixed
     */
    public function setEnabled($enabled);

    /**
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * @param $createdAt
     * @return mixed
     */
    public function setCreatedAt($createdAt);

    /**
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * @param $updatedAt
     * @return mixed
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return mixed
     */
}
