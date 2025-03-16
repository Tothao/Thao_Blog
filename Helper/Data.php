<?php

namespace Thao\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * @return mixed
     */
    public function isEnableBlog()
    {
        $isEnableBlog = $this->scopeConfig->getValue(
            'blog/general/enable',
            ScopeInterface::SCOPE_STORE,
        );
        return $isEnableBlog;
    }

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
         return $this->scopeConfig->getValue(
            'blog/general/page_title',
            ScopeInterface::SCOPE_STORE,
        );
    }
}
