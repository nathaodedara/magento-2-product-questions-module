<?php
namespace Invigorate\ProductQuestions\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $_messageManager;
    protected $redirect;
    protected $response;
    protected $_faqQuestionListDataFactory;
    protected $_faqQuestionResultDataFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Invigorate\ProductQuestions\Model\FaqQuestionListFactory $faqQuestionListDataFactory,
        \Invigorate\ProductQuestions\Model\FaqQuestionResultFactory $faqQuestionResultDataFactory
    ) {
        $this->redirect = $redirect;
        $this->response = $response;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_messageManager = $messageManager;
        $this->_faqQuestionListDataFactory = $faqQuestionListDataFactory;
        $this->_faqQuestionResultDataFactory = $faqQuestionResultDataFactory;
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPage = $this->resultPageFactory->create();
        $data = $this->getRequest()->getPost();
        $result = $this->_faqQuestionResultDataFactory->create();
        if($data){
            try {
                $question_id = $data['question_id'];
                $saveData = explode("&", $data['products']);
                if (in_array('on', $saveData))
                {
                    unset($saveData[array_search('on', $saveData)]);
                }
                $datanew = json_encode($saveData);
                $arraylength = strlen($datanew);
                if($arraylength==4){
                    $deleteModel = $this->_faqQuestionResultDataFactory->create()->getCollection()->addFieldToFilter('question_id', ['eq' , $question_id])->getData();
                    $selected_collection_delete_data = array_column($deleteModel, 'id');
                    foreach($selected_collection_delete_data as $select){
                        $result->load($select);
                        $result->delete();
                    }
                }
                else{
                    $products = $saveData;
                    $collection = $this->_faqQuestionResultDataFactory->create()->getCollection()->addFieldToFilter('question_id', ['eq' , $question_id]);
                    $tempFetchData = array_column($collection->getData(), 'product_id');
                    foreach ($products as $saveData) {
                        if (!in_array($saveData, $tempFetchData)) {
                            $saveModel = $this->_faqQuestionResultDataFactory->create();
                            $saveModel->setData('question_id', $question_id);
                            $saveModel->setData('product_id', $saveData);
                            $saveModel->save();
                        }
                    }
                    foreach ($tempFetchData as $temp) {
                        if (!in_array($temp, $products)) {
                            $deleteModel = $this->_faqQuestionResultDataFactory->create()->getCollection()->addFieldToFilter('question_id', ['eq' , $question_id])->addFieldToFilter('product_id', ['eq' , $temp])->getData();
                            $selected_collection_delete_data = array_column($deleteModel, 'id');
                            $result->load($selected_collection_delete_data);
                            $result->delete();
                        }
                    }
                }
                $question_desc = $data['question_desc'];
                $question_answer = $data['question_answer'];
                $questioner = $data['questioner'];
                $model = $this->_faqQuestionListDataFactory->create();
                $model->load($question_id);
                $model->setData('question_desc', $question_desc);
                $model->setData('question_answer', $question_answer);
                $model->setData('questioner', $questioner);
                $model->save();
                $this->_messageManager->addSuccess(__("Record updated successfully."));
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                    return $resultRedirect;
                }
                $this->redirect->redirect($this->response, 'productquestions/index');
                
            } catch (\Exception $e) {
                $this->_messageManager->addError($e->getMessage());
            }
        }
    }
}
