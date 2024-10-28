<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thao\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PostRepositoryInterface
{

    /**
     * Save post
     * @param \Thao\Blog\Api\Data\PostInterface $post
     * @return \Thao\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Thao\Blog\Api\Data\PostInterface $post);

    /**
     * Retrieve post
     * @param string $postId
     * @return \Thao\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($postId);

    /**
     * Retrieve post matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Thao\Blog\Api\Data\PostSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete post
     * @param \Thao\Blog\Api\Data\PostInterface $post
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Thao\Blog\Api\Data\PostInterface $post);

    /**
     * Delete post by ID
     * @param string $postId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($postId);
}

