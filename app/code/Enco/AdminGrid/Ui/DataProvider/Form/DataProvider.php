<?php
/**
 * Data provider for AdminGrid form
 *
 * @category Smile
 *
 */

namespace Enco\AdminGrid\Ui\DataProvider\Form;

use Enco\UrlHistory\Model\ResourceModel\UrlHistory\CollectionFactory as UrlHistoryCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData = [];

    /**
     * @var UrlHistoryCollectionFactory $urlHistoryCollectionFactory
     */
    protected $urlHistoryCollectionFactory;

    /**
     * @var RequestInterface $request
     */
    protected $request;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param UrlHistoryCollectionFactory $urlHistoryCollectionFactory
     * @param RequestInterface $request
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        UrlHistoryCollectionFactory $urlHistoryCollectionFactory,
        RequestInterface $request,
        string $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->request=$request;
        $this->collection=$urlHistoryCollectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

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
