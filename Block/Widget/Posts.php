<?php
namespace Thao\Blog\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Thao\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class Posts extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "Thao_Blog::widget/posts.phtml";

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
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $postCollectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    public function getPostList()
    {
        $currentStoreId = $this->storeManager->getStore()->getId();
        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToFilter('is_active', 1);
        $postCollection->getSelect()->where(
            'FIND_IN_SET(?, store_id) OR FIND_IN_SET(0, store_id)',
            $currentStoreId
        );

        return  $postCollection->getItems();
    }

}
