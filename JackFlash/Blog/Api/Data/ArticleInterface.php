<?php


namespace JackFlash\Blog\Api\Data;

interface ArticleInterface
{
    const ENTITY_ID                 = 'entity_id';
    const AUTHOR                    = 'author';
    const TITLE                     = 'title';
    const DESCRIPTION               = 'description';
    const CONTENT                   = 'content';
    const STATUS                    = 'status';
    const ENABLED                   = 'enabled';
    const CREATED_AT                = 'created_at';
    const UPDATED_AT                = 'updated_at';
    const URL                       = 'url';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return int
     */
    public function setId($id);

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
    public function getTitle();

    /**
     * @param $title
     * @return string
     */
    public function setTitle($title);

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
    public function getStatus();

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

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
    public function getUrl();

    /**
     * @param $url
     * @return mixed
     */
    public function setUrl($url);
}
