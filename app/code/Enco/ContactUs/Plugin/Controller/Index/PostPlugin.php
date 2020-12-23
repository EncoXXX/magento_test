<?php
/**
 * Plugin to override Magento\Contact\Controller\Index\Post
 *
 * @see Magento\Contact\Controller\Index\
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bendarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Plugin\Controller\Index;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Model\ContactUsFactory;
use Magento\Contact\Controller\Index\Post as OverrideObject;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class PostPlugin
 */
class PostPlugin
{
    /**#@+
     * Id of DataPersistor to save data
     */
    const DATA_PERSISTOR_ID = 'contact_us';
    /**@#-**/

    /**
     * Data persistor
     *
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Message manager
     *
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Redirect factory
     *
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * Request object
     *
     * @var RequestInterface $request
     */
    protected $request;

    /**
     * ContactUs model factory
     *
     * @var ContactUsFactory
     */
    protected $modelFactory;

    /**
     * Repository for ContactUs module
     *
     * @var ContactUsRepositoryInterface
     */
    protected $repository;

    /**
     * Customer session
     *
     * @var Session $customerSession
     */
    protected $customerSession;

    /**
     * PostPlugin constructor.
     *
     * @param DataPersistorInterface $dataPersistor
     * @param RequestInterface $request
     * @param Context $context
     * @param ContactUsRepositoryInterface $repository
     * @param ContactUsFactory $modelFactory
     * @param Session $customerSession
     */
    public function __construct(
        DataPersistorInterface $dataPersistor,
        RequestInterface $request,
        Context $context,
        ContactUsRepositoryInterface $repository,
        ContactUsFactory $modelFactory,
        Session $customerSession
    ) {
        $this->messageManager = $context->getMessageManager();
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
        $this->repository = $repository;
        $this->customerSession = $customerSession;
        $this->modelFactory = $modelFactory;
    }

    /**
     * Override execute method of OverrideObject
     *
     * @param OverrideObject $object
     *
     * @param callable $proceed
     *
     * @return Redirect
     */
    public function aroundExecute(OverrideObject $object, callable $proceed)
    {
        /**
         * Request
         *
         * @var RequestInterface $request
         */
        $request = $this->request;

        /**
         * ContactUs model
         *
         * @var ContactUsInterface $model
         */
        $model = $this->modelFactory->create();
        $model
            ->setCustomerName($request->getParam('name'))
            ->setCustomerId($this->customerSession->getCustomerId() ?: null)
            ->setEmail($request->getParam('email'))
            ->setTheme($request->getParam('theme'))
            ->setMessage($request->getParam('comment'))
            ->setPhone($request->getParam('telephone') ?: null)
            ->setStatus($model::NEW_MESSAGE_STATUS);

        try {
            $this->repository->save($model);
            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->dataPersistor->set(self::DATA_PERSISTOR_ID, $this->request->getParams());
        return $this->resultRedirectFactory->create()->setPath('contact/index');
    }
}
