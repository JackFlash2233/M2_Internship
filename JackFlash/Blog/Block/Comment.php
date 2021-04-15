<?php


namespace JackFlash\Blog\Block;

use JackFlash\Blog\Model\CommentRepository;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;

class Comment extends Template
{

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(
        Template\Context $context,
        CommentRepository $commentRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->commentRepository = $commentRepository;
    }

    public function getComment(): DataObject
    {
        return $this->commentRepository->getById((int)$this->getData('entity_id'));
    }
}
