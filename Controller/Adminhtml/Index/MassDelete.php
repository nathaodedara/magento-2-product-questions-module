<?php
namespace Invigorate\ProductQuestions\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $_filter;
    protected $_collectionFactory;
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Invigorate\ProductQuestions\Model\ResourceModel\FaqQuestionList\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            $logCollection = $this->_filter->getCollection($this->_collectionFactory->create());
            foreach ($logCollection as $item) {
                $item->delete();
            }
            $this->messageManager->addSuccess(__('Questions Deleted Successfully.'));
        } catch (Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
