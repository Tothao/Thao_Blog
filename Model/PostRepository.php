<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thao\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Thao\Blog\Api\Data\PostInterface;
use Thao\Blog\Api\Data\PostInterfaceFactory;
use Thao\Blog\Api\Data\PostSearchResultsInterfaceFactory;
use Thao\Blog\Api\PostRepositoryInterface;
use Thao\Blog\Model\ResourceModel\Post as ResourcePost;
use Thao\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

class PostRepository implements PostRepositoryInterface
{

    /**
     * @var ResourcePost
     */
    protected $resource;

    /**
     * @var PostInterfaceFactory
     */
    protected $postFactory;

    /**
     * @var Post
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;


    /**
     * @param ResourcePost $resource
     * @param PostInterfaceFactory $postFactory
     * @param PostCollectionFactory $postCollectionFactory
     * @param PostSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourcePost $resource,
        PostInterfaceFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        PostSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(PostInterface $post)
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the post: %1',
                $exception->getMessage()
            ));
        }
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function get($postId)
    {
        $post = $this->postFactory->create();
        $this->resource->load($post, $postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('post with id "%1" does not exist.', $postId));
        }
        return $post;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->postCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(PostInterface $post)
    {
        try {
            $postModel = $this->postFactory->create();
            $this->resource->load($postModel, $post->getPostId());
            $this->resource->delete($postModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the post: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($postId)
    {
        return $this->delete($this->get($postId));
    }
}

