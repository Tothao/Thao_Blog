<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thao\Blog\Controller\Adminhtml\Post;

use Magento\Framework\Exception\LocalizedException;
use Thao\Blog\Model\PostFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    protected $urlRewriteFactory;

    /**
     * @var \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory
     */
    protected $urlRewriteCollectionFactory;

    protected $storeManager;


    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param PostFactory $postFactory
     * @param \Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory
     * @param \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory $urlRewriteCollectionFactory
     *
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        PostFactory $postFactory,
        \Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory,
        \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory $urlRewriteCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->postFactory = $postFactory;
        $this->urlRewriteFactory =$urlRewriteFactory;
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('post_id');

            $model = $this->postFactory->create();
            $model->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Post no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            if (isset($data['image']) && is_array($data['image'])) {
                $firstItem = reset($data['image']);
                $data['image'] = $firstItem['name'];
            }

            $storeIds = [];
            if (isset($data['store_id']) && is_array($data['store_id'])) {
                $storeIds = $data['store_id'];
                $data['store_id'] = implode(',', $data['store_id']);

            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Post.'));
                $this->dataPersistor->clear('thao_blog_post');
                $stores = $this->storeManager->getStores();

                $allStoreIds = [];
                foreach ($stores as $store) {
                    $allStoreIds[] = $store->getId();
                }

                if (in_array(0, $storeIds)) {
                    $storeIds = $allStoreIds;
                }
                foreach ($storeIds as $storeId){
                    $collection = $this->urlRewriteCollectionFactory->create();
                    $collection
                        ->addFieldToFilter('store_id', $storeId)
                        ->addFieldToFilter('entity_type', 'posts')
                        ->addFieldToFilter('entity_id', $model->getPostId());

                    if ($collection->getSize()){
                        $urlRewrite = $collection->getFirstItem();
                    } else {
                        $urlRewrite = $this->urlRewriteFactory->create();
                        $urlRewrite->setEntityType("posts")
                            ->setTargetPath('blog/post/view/id/'.$model->getPostId())
                            ->setStoreId($storeId)
                            ->setEntityId($model->getPostId());
                    }
                    $urlRewrite
                        ->setrequestPath($model->getUrlKey().'.html')
                        ->save();
                }


                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Post.'));
            }

            $this->dataPersistor->set('thao_blog_post', $data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function createUrlRewrite()
    {

    }
}

