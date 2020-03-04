<?php
namespace Invigorate\ProductQuestions\Ui\Component\Operations;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    protected $urlBuilder;
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $questionData)
    {
        foreach ($questionData['data']['items'] as &$item)
        {
            $item[$this->getData('name')] = ['edit' => ['href' => $this->urlBuilder->getUrl('productquestions/*/edit', ['id' => $item['question_id']]), 'label' => __('Modify')],];
        }
        return $questionData;
    }
}
