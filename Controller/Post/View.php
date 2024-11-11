<?php

namespace Thao\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use Thao\Blog\Model\PostFactory;

class View extends Action
{
    protected $resultPageFactory;
    protected $postFactory;

    protected $resultForwardFactory;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        ForwardFactory $forwardFactory,
        PostFactory $postFactory


    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $forwardFactory;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $request = $this->getRequest();
        $postId = $request->getParam("id");
        $post = $this->postFactory->create()->load($postId);

        if (!$post->getId()) {
//            neu ko thi cho no redirect ve trang 404
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
//        doan tren nay cung la lay thong tin bai viet tu id, de kiem tra bai viet co ton tai k

//    day nhe. controller --> layout
//        trong blok de lay bai viet theo id kun lam tuong tu
        return $this->resultPageFactory->create(); // day cai nay no se return ve layout
    }
}
