<?php

namespace Thao\Blog\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;
use Thao\Blog\Helper\Data as Helper;

class TopMenu implements ObserverInterface
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @param UrlInterface $urlBuilder
     * @param Helper $helper
     */
    public function __construct(UrlInterface $urlBuilder, Helper $helper)
    {
        $this->urlBuilder = $urlBuilder;
        $this->helper = $helper;
    }

    /**
     * @param EventObserver $observer
     * @return $this|void
     */
    public function execute(EventObserver $observer)
    {
        $isEnable = $this->helper->isEnableBlog();

        if (!$isEnable) {
            return;
        }

        $menu = $observer->getMenu();
        $tree = $menu->getTree();
        $existingMenuItems = $menu->getChildren();
        $url = $this->urlBuilder->getUrl('', ['_direct' => 'blog']);
        foreach ($existingMenuItems as $existingItem) {
            if ($existingItem->getUrl() == $url) {
                return $this;
            }
        }
        $data = ['name' => __('Blog'), 'id' => 'blog', 'url' => $url, 'is_active' => false,];
        $node = new Node($data, 'id', $tree, $menu);

        $menu->addChild($node);

        return $this;
    }
}
