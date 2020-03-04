<?php
namespace Invigorate\ProductQuestions\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_storeManager;
    private $httpContext;
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Http\Context $httpContext
    ) {
        parent::__construct($context);
        $this->httpContext = $httpContext;
    }
    public function getModuleStatus()
    {
        return $this->scopeConfig->getValue(
            'productquestions/active_module/module_status',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function isLoggedIn()
    {
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        return $isLoggedIn;
    }
}
