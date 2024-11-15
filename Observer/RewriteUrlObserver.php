<?php
namespace Thao\Blog\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\UrlRewrite\Model\UrlRewriteFactory; // Để tạo bản ghi url_rewrite
use Thao\Blog\Model\Post; // Model Post của bạn

class RewriteUrlObserver implements ObserverInterface
{
    protected $urlRewriteFactory;

    public function __construct(
        UrlRewriteFactory $urlRewriteFactory
    ) {
        $this->urlRewriteFactory = $urlRewriteFactory;
    }

    /**
     * Thực thi khi bài viết blog được lưu.
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        // Lấy đối tượng Post từ sự kiện
        $post = $observer->getEvent()->getDataObject(); // Lấy model Post

        // Kiểm tra nếu đối tượng là một Post (bài viết blog)
        if ($post instanceof Post) {
            // Lấy ID bài viết
            $postId = $post->getPostId();

            // Tạo URL key theo định dạng post-{id}.html
            $urlKey = 'post-' . $postId . '.html';

            // Cập nhật URL key cho bài viết
            $post->setUrlKey($urlKey);

            // Lưu lại bài viết với URL key mới
            $post->save();

            // Tạo bản ghi trong bảng url_rewrite
            $this->createUrlRewrite($post, $urlKey);
        }
    }

    /**
     * Tạo bản ghi trong bảng url_rewrite.
     *
     * @param Post $post
     * @param string $urlKey
     */
    protected function createUrlRewrite(Post $post, string $urlKey)
    {
        $urlRewrite = $this->urlRewriteFactory->create();

        // Cấu hình các tham số cần thiết cho url_rewrite
        $urlRewrite->setEntityType('post') // Loại entity của bạn (ví dụ: 'post')
        ->setEntityId($post->getPostId()) // ID bài viết blog
        ->setRequestPath($urlKey) // URL key của bài viết
        ->setTargetPath('blog/post/view/id/' . $post->getPostId()) // URL target, trỏ tới controller blog
        ->setIsSystem(0) // Đặt 0 nếu không phải URL mặc định của Magento
        ->setStoreId($post->getStoreId()) // Store ID của bài viết
        ->setDescription('URL rewrite for blog post'); // Mô tả

        // Lưu bản ghi vào bảng url_rewrite
        $urlRewrite->save();
    }
}
