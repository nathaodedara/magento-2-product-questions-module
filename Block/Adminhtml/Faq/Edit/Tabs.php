<?php
namespace Invigorate\ProductQuestions\Block\Adminhtml\Faq\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('faq_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('FAQ Information'));
    }
    protected function _beforeToHtml()
    {
        $this->addTab(
            'faq_info',
            [
                'label' => __('Editing Record'),
                'title' => __('Editing Record'),
                'content' => $this->getLayout()->createBlock('Invigorate\ProductQuestions\Block\Adminhtml\Faq\Edit\Tab\Info')->toHtml(),
                'active' => true
            ]
        );
        $this->addTab(
            'faq_products',
            [
                'label' => __('Products'),
                'title' => __('Products'),
                'url' => $this->getUrl('productquestions/*/products', ['_current' => true]),
                'active' => false,
                'class' => 'ajax'
            ]
        );
        return parent::_beforeToHtml();
    }
}
