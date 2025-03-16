<?php

namespace Thao\Blog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Thao\Blog\Helper\Data
     */
    protected $helper;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $forwardFactory
     * @param \Thao\Blog\Helper\Data $helper
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $forwardFactory,
        \Thao\Blog\Helper\Data $helper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $forwardFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->helper->isEnableBlog()) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($this->helper->getPageTitle());
        return $resultPage;
    }
}
