<?php

namespace Thao\Blog\Block;

use Magento\Framework\View\Element\Template;
use Thao\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
class Posts extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    protected $searchCriteriaBuilder;

    protected $postRepository;

    /**
     * @param Template\Context $context
     * @param CollectionFactory $postCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context  $context,
        CollectionFactory $postCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Thao\Blog\Api\PostRepositoryInterface $postRepository,
        array             $data = []
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->storeManager = $storeManager;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->postRepository = $postRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\DataObject[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPosts()
    {

        $currentStoreId = $this->storeManager->getStore()->getId();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('is_active', 1)
            ->addFilter(
                'store_id',
                [$currentStoreId, 0],
                'in'
            )
            ->create();

        $searchResults = $this->postRepository->getList($searchCriteria);

        $posts = $searchResults->getItems();
        return $posts;

    }

    /**
     * @param $image
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getImageUrl($image)
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl.'/blog/post/'.$image;
    }
   }

