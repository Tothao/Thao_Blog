<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thao\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'post_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Thao\Blog\Model\Post::class,
            \Thao\Blog\Model\ResourceModel\Post::class
        );
    }
}

