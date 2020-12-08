<?php


namespace Enco\AdminGrid\Ui\Component\Listing\Columns;


use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class UrlHistoryActions extends Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UrlInterface $urlBuilder,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getName()] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/editUrl'),
                            [
                                $this->getData('config/idUrlParam') => $item['id']
                            ]
                        ),
                        'label' => __('Edit')
                    ],
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/deleteUrl'),
                            [
                                $this->getData('config/idUrlParam') => $item['id']
                            ]
                        ),
                        'label' => __('Delete')
                    ],
                    'preview' => [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/previewUrl'),
                            [
                                $this->getData('config/idUrlParam') => $item['id']
                            ]
                        ),
                        'label' => __('Preview')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
