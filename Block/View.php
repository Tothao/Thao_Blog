<?php

namespace Thao\Blog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Cms\Model\Template\FilterProvider;
use Thao\Blog\Model\PostFactory;
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


    /**
     * @param Template\Context $context
     * @param PostFactory $postFactory
     * @param FilterProvider $filterProvider
     * @param RequestInterface $request
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostFactory $postFactory,
        FilterProvider $filterProvider,
        RequestInterface $request,
        array $data = []
    ) {
        $this->postFactory = $postFactory;
        $this->_filterProvider = $filterProvider;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function _toHtml()
    {
        $post = $this->getPost();
        if ($post->getId()) {
            $html = $this->_filterProvider->getPageFilter()->filter($post->getContent());
            return $html;
        }
        return '';
        $html="";
        $html.='<div style="margin-bottom: 18px">Author:'.$this->getPost()->getAuthor().'</div>';
        if($post->getId()){
            $html .= $this->_filterProvider->getPageFilter()->filter($post->getContent());
            return $html;
        }
        return'';
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

    /**
     * @return View
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _prepareLayout()
    {
        if ($this->getLayout()->getBlock('page.main.title')) {
            $this->getLayout()->getBlock('page.main.title')->setPagetitle($this->getPost()->getTitle());
        }
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
        if ($breadcrumbsBlock) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'), //lable on breadCrumbes
                    'title' => __('Home'),
                    'link' => $this->getBaseUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'blog',
                [
                    'label' => __('blog'),
                    'title' => __('blog'),
                    'link' => $this->getUrl('blog')
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'post-view',
                [
                    'label' => __($this->getPost()->getTitle()),
                    'title' => __($this->getPost()->getTitle()),
                    'link' => ''
                ]
            );
        }

        return parent::_prepareLayout();

    }


}
