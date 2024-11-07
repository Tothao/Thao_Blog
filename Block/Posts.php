<?php

namespace Thao\Blog\Block;

use Magento\Framework\View\Element\Template;
use Thao\Blog\Model\PostFactory;
use Thao\Blog\Model\ResourceModel\Post\CollectionFactory;

class Posts extends Template
{
//    minh se dung factory thay vi dung truc tiep cai class collection ma minh da tao.
//class factory se duoc tu dong sinh ra
    protected $postCollectionFactory;

    public function __construct(
        Template\Context  $context,
        CollectionFactory $postCollectionFactory,
        array             $data = []
    )
    {
        $this->postCollectionFactory = $postCollectionFactory;
        parent::__construct($context, $data);
    }

//    trong nay kun se viet mot ham de lay tat ca cac bai posts

    public function getPosts()
    {
//        gio moi dung den cai collection day nay
//        binh thuong new muon khai bao doi tuong trong php thi minh dung new

//        $postCollection = new Collection(); nhu nay dung ko
//        nhung trong magento thi thuong se ko lam the. ma se khai bao vao contruct va gan vao mot thuoc tinh luon
//    gio de lay tat da cac bai viet thi se viet ntn
        $postCollectionFactory = $this->postCollectionFactory->create();
        $posts = $postCollectionFactory->getItems();
        return $posts;
//    do xong r
    }
}

