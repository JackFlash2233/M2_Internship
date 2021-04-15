<?php

namespace JackFlash\Blog\Block;

use Magento\Framework\DataObject;
use JackFlash\Blog\Model\ArticleRepository;
use JackFlash\Blog\Model\ResourceModel\EavOptions\CollectionFactory;
use Magento\Framework\View\Element\Template;

class Blog extends Template
{
    /**
     * @var RequestInterface
     */
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        ArticleRepository $articleRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->articleRepository = $articleRepository;
    }

    public function getDataArticle()
    {
        return $this->articleRepository->getById((int)$this->getData('article_id'));
    }
}
