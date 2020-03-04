<?php
namespace Invigorate\ProductQuestions\Controller\Adminhtml\Index;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $jsonFactory;
    protected $_messageManager;
    protected $_faqRecordsDataFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Invigorate\ProductQuestions\Model\FaqQuestionListFactory $faqQuestionListDataFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->_faqQuestionListDataFactory = $faqQuestionListDataFactory;
        $this->_messageManager = $messageManager;
    }
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $questionId) {
                    $model = $this->_faqQuestionListDataFactory->create();
                    $model->load($questionId);
                    try {
                        $model->setData(array_merge($model->getData(), $postItems[$questionId]));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Error:]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
