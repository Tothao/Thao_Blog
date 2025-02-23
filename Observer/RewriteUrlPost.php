<?php
namespace Thao\Blog\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Thao\Blog\Model\Post;

class RewriteUrlPost implements ObserverInterface
{
    protected $urlRewriteFactory;


    public function __construct(
        UrlRewriteFactory $urlRewriteFactory
    ) {
        $this->urlRewriteFactory = $urlRewriteFactory;

    }

    /**
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $post = $observer->getEvent()->getDataObject();
            $postId = $post->getPostId();
            $titel = $post->getTitle();
            $urlKey = $titel. $postId ;
            $post->setUrlKey($urlKey);
            $post->save();
            $this->createUrlRewrite($post, $urlKey);
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
        $urlRewrite->setEntityType('thao_blog_post')
        ->setEntityId($post->getPostId())
        ->setRequestPath($urlKey)
        ->setTargetPath('blog/post/view/id/' . $post->getPostId()) // URL target, trỏ tới controller blog
        ->setIsSystem(0) // Đặt 0 nếu không phải URL mặc định của Magento
        ->setStoreId($post->getStoreId()) // Store ID của bài viết
        ->setDescription('URL rewrite for blog post'); // Mô tả

        // Lưu bản ghi vào bảng url_rewrite
        $urlRewrite->save();
    }
}
