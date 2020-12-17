<?php
/**
 * Columns for admingrid action
 * Actions for ContactUs admingrid
 * @categore Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\ContactUs\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class ContactUsActions
 * @package Enco\ContactUs\Ui\Component\Listing\Columns
 */
class ContactUsActions extends Column
{
    /**
     * @var UrlInterface $urlBuilder
     */
    protected $urlBuilder;

    /**
     * ContactUsActions constructor.
     * @param ContextInterface $context
     * @param UrlInterface $urlBuilder
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
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

    /**
     * Prepare Data Source (action column component)
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getName()] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/edit'),
                            [
                                $this->getData('config/idMessageParam') => $item['id']
                            ]
                        ),
                        'label' => __('Edit')
                    ],
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/delete'),
                            [
                                $this->getData('config/idMessageParam') => $item['id']
                            ]
                        ),
                        'label' => __('Delete')
                    ],
                    'preview' => [
                        'href' => $this->urlBuilder->getUrl(
                            $this->getData('config/preview'),
                            [
                                $this->getData('config/idMessageParam') => $item['id']
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
