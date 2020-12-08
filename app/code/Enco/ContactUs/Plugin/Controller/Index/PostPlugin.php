<?php
/**
 * Plugin to override Magento\Contact\Controller\Index\Post
 * @see Magento\Contact\Controller\Index\
 * @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bendarsasha@gmail.com>
 * @copyright 2020 Smile
 */

namespace Enco\ContactUs\Plugin\Controller\Index;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Model\ContactUsFactory;
use Exception;
use Magento\Contact\Controller\Index\Post as OverrideObject;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class PostPlugin
 * @package Enco\ContactUs\Plugin\Controller\Index
 */
class PostPlugin
{
    const DATA_PERSISTOR_ID = 'contact_us';
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var RequestInterface $request
     */
    protected $request;

    /**
     * @var ContactUsFactory
     */
    protected $modelFactory;

    /**
     * @var ContactUsRepositoryInterface
     */
    protected $repository;

    /**
     * @var Session $customerSession
     */
    protected $customerSession;

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
     * @param OverrideObject $object
     * @param callable $proceed
     * @return Redirect
     * @throws LocalizedException
     */
    public function aroundExecute(OverrideObject $object, callable $proceed)
    {
        $request = $this->request;
        /**
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

        $answer = $this->repository->save($model);

        if ($answer !== null) {
            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
        }

        $this->dataPersistor->set(self::DATA_PERSISTOR_ID, $this->request->getParams());
        return $this->resultRedirectFactory->create()->setPath('contact/index');
    }
}
