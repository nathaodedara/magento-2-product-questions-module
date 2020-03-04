<?php
namespace Invigorate\ProductQuestions\Model\ResourceModel\FaqQuestionList;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Invigorate\ProductQuestions\Model\FaqQuestionList as Model;
use Invigorate\ProductQuestions\Model\ResourceModel\FaqQuestionList as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'question_id';
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
