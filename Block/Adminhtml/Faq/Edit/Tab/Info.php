<?php
namespace Invigorate\ProductQuestions\Block\Adminhtml\Faq\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

class Info extends Generic implements TabInterface
{
    protected $_faqQuestionListDataFactory;
    protected $redirect;
    protected $response;
    public function __construct(
        Context $context,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Invigorate\ProductQuestions\Model\FaqQuestionListFactory $faqQuestionListDataFactory,
        Registry $registry,
        \Magento\Framework\App\Request\Http $request,
        FormFactory $formFactory,
        array $data = []
    ) {
        $this->_faqQuestionListDataFactory = $faqQuestionListDataFactory;
        $this->redirect = $redirect;
        $this->response = $response;
        $this->request = $request;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    protected function _prepareForm()
    {
        $question_id = $this->request->getParam('id');
        $model = $this->_faqQuestionListDataFactory->create();
        $questionData = $model->load($question_id);
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Question Details')]
        );
        if ($questionData->getData()) {
            $data = $questionData->getData();
            $fieldset->addField(
                'question_id',
                'hidden',
                ['name' => 'question_id']
            );
            $fieldset->addField(
                'question_desc',
                'textarea',
                [
                    'name'        => 'question_desc',
                    'class'        => 'editquestiontextarea',
                    'label'    => __('Question'),
                    'required'     => true
                ]
            );
            $model->setData('question_desc', $data['question_desc']);
            $fieldset->addField(
                'question_answer',
                'textarea',
                [
                    'name'        => 'question_answer',
                    'class'        => 'editquestiontextarea',
                    'label'    => __('Question Answer')
                ]
            );
            $model->setData('question_answer', $data['question_answer']);
            $fieldset->addField(
                'questioner',
                'text',
                [
                    'name'        => 'questioner',
                    'label'    => __('Asked by'),
                    'required'     => true
                ]
            );
            $model->setData('question_answer', $data['question_answer']);
        } else {
            $this->redirect->redirect($this->response, 'productquestions/index');
        }
        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();
    }
    public function getTabLabel()
    {
        return __('FAQ Info');
    }
    public function getTabTitle()
    {
        return __('FAQ Info');
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
}
