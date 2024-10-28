<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thao\Blog\Api\Data;

interface PostSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get post list.
     * @return \Thao\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Thao\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

