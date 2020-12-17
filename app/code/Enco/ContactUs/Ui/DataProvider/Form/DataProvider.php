<?php
/**
 * Data provider for ContactUs form
 *
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Ui\DataProvider\Form;

use Enco\ContactUs\Model\ResourceModel\ContactUs\CollectionFactory as ContactUsCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider for ContactUs form
 * @package Enco\ContactUs\Ui\DataProvider\Form
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData = [];

    /**
     * @var RequestInterface $request
     */
    protected $request;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param ContactUsCollectionFactory $contactUsCollectionFactory
     * @param RequestInterface $request
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        ContactUsCollectionFactory $contactUsCollectionFactory,
        RequestInterface $request,
        string $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->request=$request;
        $this->collection=$contactUsCollectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Returns loaded data in ContactUs form
     * @return array
     */
    public function getData()
    {
        if (!empty($this->_loadedData)) {
            return $this->_loadedData;
        }

        foreach ($this->getCollection() as $item) {
            $this->_loadedData[$item->getId()] = $item->getData();
        }

        return $this->_loadedData;
    }
}
