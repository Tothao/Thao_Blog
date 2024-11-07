<?php

namespace Thao\Blog\Controller\index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Thao\Blog\Model\PostFactory;
use Magento\Framework\View\Result\PageFactory;
// Chúng ta sẽ sử dụng PostFactory để truy xuất bài viết

class index extends Action
{
    protected $postFactory;
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PostFactory $postFactory,
        PageFactory $resultPageFactory
    ) {
        $this->postFactory = $postFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        // Lấy category ID từ URL
//        $categoryId = $this->getRequest()->getParam('id');

        // Lấy các bài viết từ bảng thao_blog_post dựa vào category
//        $posts = $this->postFactory->create()->getCollection()
//            ->addFieldToFilter('post_id', $categoryId);  // Giả sử bảng có trường category_id

        // Truyền dữ liệu vào block để hiển thị trên frontend
//        $this->_view->getLayout()->getBlock('blog.category.posts')->setData('posts', $posts);

        // Trả về trang kết quả
        return $this->resultPageFactory->create();
    }
}
