<?php
/**
 * Helper for Contact Us
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Helper;

use Enco\ContactUs\Contorller\Index\Post;
use Enco\ContactUs\Contorller\Index\Post as PostAction;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class Data
 * @package Enco\ContactUs\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var Session $customerSession
     */
    protected $customerSession;

    /**
     * @var DataPersistorInterface $dataPersistor
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $persistorData = [];

    /**
     * Flag to load data from data Persistor
     * @var bool
     */
    protected $dataLoaded = false;

    /**
     * Returns data persistor or null
     * @return array
     */
    private function getDataPersistor()
    {
        if ($this->dataLoaded == false) {
            $this->persistorData = $this->dataPersistor->get(PostAction::DATA_PERSISTOR_ID);
            $this->dataLoaded = true;
            $this->dataPersistor->clear(Post::DATA_PERSISTOR_ID);
        }
        return $this->persistorData;
    }

    /**
     * Data constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        DataPersistorInterface $dataPersistor
    ) {
        $this->customerSession = $customerSession;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Returns customer name from form or from customer session
     * @return string
     */
    public function getCustomerName()
    {
        if (isset($this->getDataPersistor()['name']) and trim($this->getDataPersistor()['name']) != '') {
            return $this->getDataPersistor()['name'];
        }
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomerDataObject()->getFirstname() ?: '';
        }
        return '';
    }

    /**
     * Returns customer email from form or from customer session
     * @return string
     */
    public function getCustomerEmail()
    {
        if (isset($this->getDataPersistor()['email']) and trim($this->getDataPersistor()['email']) != '') {
            return $this->getDataPersistor()['email'];
        }
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomerDataObject()->getEmail() ?: '';
        }
        return '';
    }

    /**
     * Returns customer phone from form
     * @return string
     */
    public function getCustomerPhone()
    {
        if (isset($this->getDataPersistor()['telephone']) and trim($this->getDataPersistor()['telephone'])) {
            return $this->getDataPersistor()['telephone'];
        }

        return '';
    }

    /**
     * Returns theme from form
     * @return string
     */
    public function getTheme()
    {
        if (isset($this->getDataPersistor()['theme']) and trim($this->getDataPersistor()['theme'])) {
            return $this->getDataPersistor()['theme'];
        }

        return '';
    }

    /**
     * Returns comment from form
     * @return string
     */
    public function getComment()
    {
        if (isset($this->getDataPersistor()['comment']) and trim($this->getDataPersistor()['comment'])) {
            return $this->getDataPersistor()['comment'];
        }

        return '';
    }
}
