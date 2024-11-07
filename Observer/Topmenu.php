<?php

namespace Thao\Blog\Observer;
    use Magento\Framework\Event\Observer as EventObserver;
    use Magento\Framework\Data\Tree\Node;
    use Magento\Framework\Event\ObserverInterface;

    class Topmenu implements ObserverInterface
    {
        public function __construct()
        {
        }

        public function execute(EventObserver $observer)
        {
            $menu = $observer->getMenu();
            $tree = $menu->getTree();
            $data = ['name' => __('Blog'),
                'id' => 'blog_menu',
                'url' => 'blog/index/index',
                'is_active' => true];
            $parentNode = new Node($data, 'id', $tree, $menu);
            $menu->addChild($parentNode);
            $subMenuData = [
                'name' => __('Blog Category 1'),      // Tên menu con
                'id' => 'some-unique-sub-id-1',       // ID menu con
                'url' => 'blog/index/index',    // URL menu con
                'is_active' => true
            ];
            $subMenuNode = new Node($subMenuData, 'id', $tree, $menu);

            // Thêm menu con vào menu cha
            $parentNode->addChild($subMenuNode);

            return $this;
        }


    }
