<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thao\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('thao_blog_post', 'post_id');
    }
}

