<?php

namespace Thao\Blog\Controller\Post;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use Thao\Blog\Model\PostFactory;

class View extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $forwardFactory
     * @param PostFactory $postFactory
     * @param ProductFactory $productFactory
     */
    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        ForwardFactory $forwardFactory,
        PostFactory $postFactory,
        ProductFactory $productFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $forwardFactory;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $request = $this->getRequest();
        $postId = $request->getParam("id");
        $post = $this->postFactory->create()->load($postId);

        if (!$post->getId()) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        return $this->resultPageFactory->create();
    }
}
