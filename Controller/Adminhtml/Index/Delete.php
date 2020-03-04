<?php
namespace Invigorate\ProductQuestions\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $_messageManager;
    protected $redirect;
    protected $response;
    protected $_faqQuestionListDataFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Invigorate\ProductQuestions\Model\FaqQuestionListFactory $faqQuestionListDataFactory
    ) {
        $this->redirect = $redirect;
        $this->response = $response;
        $this->request = $request;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_messageManager = $messageManager;
        $this->_faqQuestionListDataFactory = $faqQuestionListDataFactory;
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $question_id = $this->request->getParam('id');
        if ($question_id) {
            try {
                $model = $this->_faqQuestionListDataFactory->create();
                $model->load($question_id);
                $model->delete();
                $this->_messageManager->addSuccess(__("Record deleted successfully."));
                $this->redirect->redirect($this->response, 'productquestions/index');
            } catch (\Exception $e) {
                $this->_messageManager->addError($e->getMessage());
            }
        } else {
            $this->redirect->redirect($this->response, 'productquestions');
        }
    }
}
