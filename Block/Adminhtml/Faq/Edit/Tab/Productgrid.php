<?php
namespace Invigorate\ProductQuestions\Block\Adminhtml\Faq\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Registry;

class Productgrid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_coreRegistry = null;
    protected $_productFactory;
    protected $_faqQuestionListDataFactory;
    protected $_faqQuestionResultDataFactory;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Invigorate\ProductQuestions\Model\FaqQuestionListFactory $faqQuestionListDataFactory,
        \Invigorate\ProductQuestions\Model\FaqQuestionResultFactory $faqQuestionResultDataFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_productFactory = $productFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_faqQuestionListDataFactory = $faqQuestionListDataFactory;
        $this->_faqQuestionResultDataFactory = $faqQuestionResultDataFactory;
        parent::__construct($context, $backendHelper, $data);
    }
    protected function _construct()
    {
        parent::_construct();
        $this->setId('product_grid');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(['products' => 1]);
        }
    }
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'products') {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
    protected function _prepareCollection()
    {
        $collection = $this->_productFactory->create()->getCollection();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('price');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'products',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'products',
                'align' => 'center',
                'index' => 'entity_id',
                'values' => $this->_getSelectedProducts(),
            ]
        );
        $this->addColumn('entity_id', [
            'header' => __('Product ID'),
            'index' =>'entity_id',
            'header_css_class' =>'col-entity_id',
            'column_css_class' =>'col-entity_id'
        ]);
        $this->addColumn('name', [
            'header' => __('Product Name'),
            'index' => 'name',
            'header_css_class' => 'col-name',
            'column_css_class' => 'col-name'
        ]);
        $this->addColumn('sku', [
            'header' => __('SKU'),
            'index' =>'sku',
            'header_css_class' =>'col-sku',
            'column_css_class' =>'col-sku'
        ]);
        return parent::_prepareColumns();
    }
    public function getGridUrl()
    {

        return $this->getUrl('*/*/productgrid', ['_current' => true]);
    }
    public function getRowUrl($row)
    {
        return '';
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return true;
    }
    protected function _getSelectedProducts()
    {
        $question_id = $this->getRequest()->getParam('id');
        $collection = $this->_faqQuestionResultDataFactory->create()->getCollection();
        $collection->addFieldToFilter('question_id', ['eq' , $question_id]);
        $data = $collection->getData();
        $products = array_column($data, 'product_id');
        return $products;
    }
    public function getSelectedProducts()
    {
        $question_id = $this->getRequest()->getParam('id');
        $collection = $this->_faqQuestionResultDataFactory->create()->getCollection();
        $collection->addFieldToFilter('question_id', ['eq' , $question_id]);
        $data = $collection->getData();
        $products = array_column($data, 'product_id');
        return $products;
    }
}
