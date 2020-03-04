<?php
namespace Invigorate\ProductQuestions\Model;

use Magento\Framework\Model\AbstractModel;
use Invigorate\ProductQuestions\Model\ResourceModel\FaqQuestionList as ResourceModel;

class FaqQuestionList extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
