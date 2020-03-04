<?php
namespace Invigorate\ProductQuestions\Model\ResourceModel\FaqQuestionResult;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Invigorate\ProductQuestions\Model\FaqQuestionResult as Model;
use Invigorate\ProductQuestions\Model\ResourceModel\FaqQuestionResult as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
