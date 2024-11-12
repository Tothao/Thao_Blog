<?php

namespace Thao\Blog\Observer;
    use Magento\Framework\Event\Observer as EventObserver;
    use Magento\Framework\Data\Tree\Node;
    use Magento\Framework\Event\ObserverInterface;
    use Magento\Framework\UrlInterface;

    class Topmenu implements ObserverInterface
    {

        protected $urlBuilder;
        public function __construct(
            UrlInterface $urlBuilder
        )
        {
            $this->urlBuilder = $urlBuilder;
        }

        public function execute(EventObserver $observer)
        {
            $menu = $observer->getMenu();
            $tree = $menu->getTree();
            $existingMenuItems = $menu->getChildren();
            $url = $this->urlBuilder->getUrl('', ['_direct' => 'blog']); // Example URL
            foreach ($existingMenuItems as $existingItem) {
                if ($existingItem->getUrl() == $url) {
                    return $this; // Do not add a duplicate menu item
                }
            }
            $data = [
                'name'      => __('Blog'),
                'id'        => 'some-unique-id-here', // Unique ID for the new menu item
                'url'       => $url, // URL generated dynamically
                'is_active' => false, // Adjust this condition to dynamically determine if the item is active
            ];
            $node = new Node($data, 'id', $tree, $menu);

            // Add the new menu item to the top menu
            $menu->addChild($node);

            return $this;
        }
//            $parentNode = new Node($data, 'id', $tree, $menu);
//            $menu->addChild($parentNode);
//            $subMenuData = [
//                'name' => __('Blog Category 1'),      // Tên menu con
//                'id' => 'some-unique-sub-id-1',       // ID menu con
//                'url' => 'blog/index/index',    // URL menu con
//                'is_active' => true
//            ];
//            $subMenuNode = new Node($subMenuData, 'id', $tree, $menu);
//
//            // Thêm menu con vào menu cha
//            $parentNode->addChild($subMenuNode);
//
//            return $this;
//        }


    }
