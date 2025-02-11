<?php

namespace Thao\Blog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
// Chúng ta sẽ sử dụng PostFactory để truy xuất bài viết

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
//        cho nay kun lam giong trong menu. lay config ra. kiem tra neu menu tat thi redirect ve trang 404

        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('noroute');
        //return ve layout luon
        return $this->resultPageFactory->create();
    }
}
