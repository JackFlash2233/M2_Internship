<?php


namespace JackFlash\Blog\Controller\Article;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use JackFlash\Blog\Model\ArticleRepository;
use JackFlash\Blog\Model\ResourceModel\ArticleFactory;
use JackFlash\Blog\Model\ArticleSearchResult;

class TestRep extends Action
{
    /**
     * @var ArticleFactory
     */
    private $articleFactory;
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var ArticleSearchResult
     */
    private $articleSearchResult;
    private $filterBuilder;

    /**
     * @inheritDoc
     */
    public function __construct(
        Context $context,
        ArticleFactory $articleFactory,
        ArticleRepository $articleRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ArticleSearchResult $articleSearchResult,
        FilterBuilder $filterBuilder
    ) {
        parent::__construct($context);
        $this->articleFactory = $articleFactory;
        $this->articleRepository = $articleRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->articleSearchResult = $articleSearchResult;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->articleFactory->create();

        // GetById
        $tmp = $this->articleRepository->getById(15);

        // Poisk
        $filter1 = $this->filterBuilder
            ->setField('description')
            ->setValue('Desc21')
            ->setConditionType('eq')
            ->create();

        $filter2 = $this->filterBuilder
            ->setField('description')
            ->setValue('Desc2')
            ->setConditionType('eq')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('title', 'Titile')
            ->addFilters([$filter1, $filter2])
            ->create();

        $searchResult = $this->articleRepository->getList($searchCriteria);
        $articles = $searchResult->getItems();

        $result = '';
        foreach ($articles as $article) {
            $result .= $article->getId() . '<br>';
        }

        //save
        $saveResult = $this->articleFactory->create();
        $saveResult->setData(
            [
                'author' => 'Kail1',
                'title' => 'About cag1t',
                'description' => 'Sojm1e cat.......',
                'content' => 'Content1f about cat',
                'status' => 1,
                'enabled' => 1
            ]
        );
    }
}
