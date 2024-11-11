<?php

namespace Thao\Blog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Cms\Model\Template\FilterProvider;
use Thao\Blog\Model\PostFactory;  // Đảm bảo rằng bạn đã khai báo đúng PostFactory
use Magento\Framework\App\RequestInterface;

class View extends Template
{
    /**
     * @var PostFactory
     */
    protected $postFactory;

    /**
     * @var FilterProvider cai nay khai bao gi a
     */
    protected $_filterProvider;

    // Constructor để inject dependencies
    public function __construct(
        Template\Context $context,
        PostFactory $postFactory,  // Inject PostFactory
        FilterProvider $filterProvider,  // Inject FilterProvider
        RequestInterface $request,  // Inject RequestInterface
        array $data = []
    ) {
        $this->postFactory = $postFactory;
        $this->_filterProvider = $filterProvider;
        $this->request = $request;  // Lưu đối tượng Request vào biến
        parent::__construct($context, $data);
    }


    // Override phương thức _toHtml() để đảm bảo nội dung bài viết được trả về
    protected function _toHtml()
    {
        $post = $this->getPost();

//        kun ko tach ham ra thi viet vao day cung dc.
//        tach ra cho no gon gang thoi tach ra di ck
        // tren nay thi chi la goi ham do ra de lay thon tin bai viet
        if ($post->getId()) {  // Kiểm tra nếu bài viết tồn tại
            // Lọc nội dung bài viết thông qua FilterProvider
            $html = $this->_filterProvider->getPageFilter()->filter($post->getContent());

            return $html;
        }
        return '';  // Trả về chuỗi rỗng nếu không tìm thấy bài viết
    }

    /**
     * Lay post theo id get tu param\
     * ham nay la 1 ham de lay thong tin bai viet theo id , id thi lay tu param nhe
     *
     * @return \Thao\Blog\Model\Post
     */
    protected function getPost()
    {
        $postId = $this->request->getParam('id');
        $postFactory = $this->postFactory->create()->load($postId);
        return $postFactory;
    }
}
