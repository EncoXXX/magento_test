<?php
/**
 * Helper for Contact Us
 *
 * @category Smile Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Helper;

use Enco\ContactUs\Plugin\Controller\Index\PostPlugin;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Zend_Validate_NotEmpty;

/**
 * Class Data
 */
class Data extends AbstractHelper
{
    /**
     * Customer session
     *
     * @var Session $customerSession
     */
    protected $customerSession;

    /**
     * Data persistor
     *
     * @var DataPersistorInterface $dataPersistor
     */
    protected $dataPersistor;

    /**
     * Array to load data from data persistor
     *
     * @var array
     */
    protected $persistorData = [];

    /**
     * Flag to load data from data Persistor
     *
     * @var bool
     */
    protected $dataLoaded = false;

    /**
     * Not empty validator
     *
     * @var Zend_Validate_NotEmpty $validator
     */
    protected $validator = null;

    /**
     * Returns data persistor or null
     *
     * @return array
     */
    protected function getDataPersistor()
    {
        if (!$this->dataLoaded) {
            $this->persistorData = $this->dataPersistor->get(PostPlugin::DATA_PERSISTOR_ID);
            $this->dataLoaded = true;
            $this->dataPersistor->clear(PostPlugin::DATA_PERSISTOR_ID);
        }
        return $this->persistorData;
    }

    /**
     * Data constructor.
     *
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
     *
     * @return string
     */
    public function getCustomerName()
    {
        if ($this->getValidator()->isValid($this->getDataPersistor()['name'])) {
            return $this->getDataPersistor()['name'];
        }
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomerDataObject()->getFirstname() ?: '';
        }
        return '';
    }

    /**
     * Returns customer email from form or from customer session
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        if ($this->getValidator()->isValid($this->getDataPersistor()['email']) != '') {
            return $this->getDataPersistor()['email'];
        }
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomerDataObject()->getEmail() ?: '';
        }
        return '';
    }

    /**
     * Returns customer phone from form
     *
     * @return string
     */
    public function getCustomerPhone()
    {
        if ($this->getValidator()->isValid($this->getDataPersistor()['telephone'])) {
            return $this->getDataPersistor()['telephone'];
        }

        return '';
    }

    /**
     * Returns theme from form
     *
     * @return string
     */
    public function getTheme()
    {
        if ($this->getValidator()->isValid($this->getDataPersistor()['theme'])) {
            return $this->getDataPersistor()['theme'];
        }

        return '';
    }

    /**
     * Returns comment from form
     *
     * @return string
     */
    public function getComment()
    {
        if ($this->getValidator()->isValid($this->getDataPersistor()['comment'])) {
            return $this->getDataPersistor()['comment'];
        }

        return '';
    }

    /**
     * Create end return zend validator
     *
     * @return Zend_Validate_NotEmpty
     */
    public function getValidator()
    {
        if ($this->validator == null) {
            $this->validator = new Zend_Validate_NotEmpty();
        }
        return $this->validator;
    }
}
