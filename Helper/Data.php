<?php
namespace Thao\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
class Data extends AbstractHelper
{
    public function isEnableBlog()
    {
        $valueFromConfig = $this->scopeConfig->getValue(
            'blog/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );

        return $valueFromConfig;
    }

}
