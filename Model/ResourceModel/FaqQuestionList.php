<?php
namespace Invigorate\ProductQuestions\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FaqQuestionList extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('product_faq_question_list', 'question_id');
    }
}
