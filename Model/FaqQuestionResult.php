<?php
namespace Invigorate\ProductQuestions\Model;

use Magento\Framework\Model\AbstractModel;
use Invigorate\ProductQuestions\Model\ResourceModel\FaqQuestionResult as ResourceModel;

class FaqQuestionResult extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
