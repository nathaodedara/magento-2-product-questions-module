<?php
namespace Invigorate\ProductQuestions\Controller\Addfaq;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;

class Index extends Action
{
    protected $_messageManager;
    protected $_faqQuestionListDataFactory;
    protected $_faqQuestionResultDataFactory;
    public function __construct(
        Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Invigorate\ProductQuestions\Model\FaqQuestionListFactory $faqQuestionListDataFactory,
        \Invigorate\ProductQuestions\Model\FaqQuestionResultFactory $faqQuestionResultDataFactory
    ) {
        parent::__construct($context);
        $this->_messageManager = $messageManager;
        $this->_faqQuestionListDataFactory = $faqQuestionListDataFactory;
        $this->_faqQuestionResultDataFactory = $faqQuestionResultDataFactory;
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $post = (array) $this->getRequest()->getPost();
        if (!empty($post)) {
            try {
                $question_desc = $post['txtarea_question'];
                $questioner = $post['txt_questioner'];
                $product_id = $post['product_id'];
                $error = 0;
                if ($question_desc == '') {
                    $this->_messageManager->addError(__("Question cannot be empty."));
                    $error = 1;
                }
                if ($questioner == '') {
                    $this->_messageManager->addError(__("Name must be entered."));
                    $error = 1;
                }
                if ($error == 0) {
                    /*$model->setData('product_id', $product_id);*/
                    $model = $this->_faqQuestionListDataFactory->create();
                    $model->setData('question_desc', $question_desc);
                    $model->setData('questioner', $questioner);
                    $model->save();
                    $insertedQuestionId = $model->getId();
                    $model2 = $this->_faqQuestionResultDataFactory->create();
                    $model2->setData('question_id', $insertedQuestionId);
                    $model2->setData('product_id', $product_id);
                    $model2->save();
                    $msg = "Question successfully added.";
                    $this->_messageManager->addSuccess(__($msg));
                    $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                    return $resultRedirect;
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
