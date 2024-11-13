<?php

namespace Thao\Blog\Block;

use Magento\Framework\View\Element\Template;
use Thao\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ObjectManager;
class Posts extends Template
{
//    minh se dung factory thay vi dung truc tiep cai class collection ma minh da tao.
//class factory se duoc tu dong sinh ra
    protected $postCollectionFactory;
    protected $storeManager;

    public function __construct(
        Template\Context  $context,
        CollectionFactory $postCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array             $data = []
    )
    {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

//    trong nay kun se viet mot ham de lay tat ca cac bai posts

    public function getPosts()
    {
//
        $currentStoreId = $this->storeManager->getStore()->getId();
        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToFilter('is_active', 1);
        $postCollection->getSelect()->where(
            'FIND_IN_SET(?, store_id) OR FIND_IN_SET(0, store_id)',
            $currentStoreId
        );
        $posts = $postCollection->getItems();
        return $posts;
//
    }

    public function getImageUrl($image)
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl.'/blog/post/'.$image;
    }
   }

