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
        array             $data = []
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Framework\DataObject[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPosts()
    {

        $currentStoreId = $this->storeManager->getStore()->getId();
        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToFilter('is_active', 1);
        $postCollection->getSelect()->where(
            'FIND_IN_SET(?, store_id) OR FIND_IN_SET(0, store_id)',
            $currentStoreId
        );
        $posts = $postCollection->getItems();
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

