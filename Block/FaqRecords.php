<?php
namespace Invigorate\ProductQuestions\Block;

use Magento\Framework\View\Element\Template\Context;
use Invigorate\ProductQuestions\Model\FaqQuestionResultFactory;

class FaqRecords extends \Magento\Framework\View\Element\Template
{
    public $countryFactory;
    protected $_countryCollectionFactory;
    protected $_faqQuestionResultDataFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Invigorate\ProductQuestions\Model\FaqQuestionResultFactory $faqQuestionResultDataFactory,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $data);
        $this->_faqQuestionResultDataFactory = $faqQuestionResultDataFactory;
    }
    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Simple Custom Module List Page'));
        return parent::_prepareLayout();
    }
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
    public function getProductQuestions()
    {
        $product_id = $this->getCurrentProduct()->getId();
        $collection = $this->_faqQuestionResultDataFactory->create()->getCollection();
        $collection->addFieldToFilter('product_id', $product_id);
        $collection->addFieldToFilter('question_answer', ['neq' => '']);
        $collection->getSelect()->joinLeft(
            ['product_faq_question_list'=>$collection->getTable('product_faq_question_list')],
            'main_table.question_id = product_faq_question_list.question_id'
        );
        return $collection;
    }
}
