<?php
/**
 * Write test data in DB for module ContactUs

* @category Smile
 * @package Enco\ContactUs
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Enco
 */

namespace Enco\ContactUs\Setup\Patch\Data;

use Enco\ContactUs\Api\ContactUsRepositoryInterface;
use Enco\ContactUs\Api\Data\ContactUsInterface;
use Enco\ContactUs\Api\Data\ContactUsInterfaceFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class TestData implements DataPatchInterface
{
    /**
     * Data setup for module
     *
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    protected $moduleDataSetup;

    /**
     * ContactUs model factory
     *
     * @var ContactUsInterfaceFactory $contactUsFactory
     */
    protected $contactUsFactory;

    /**
     * Repository for ContactUs module
     *
     * @var ContactUsRepositoryInterface
     */
    protected $contactUsRepository;

    /**
     * TestData constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ContactUsRepositoryInterface $contactUsRepository
     * @param ContactUsInterfaceFactory $contactUsFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ContactUsRepositoryInterface $contactUsRepository,
        ContactUsInterfaceFactory $contactUsFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->contactUsFactory = $contactUsFactory;
        $this->contactUsRepository = $contactUsRepository;
    }

    /**
     * Returns dependencies of this patch
     *
     * @return string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Return aliases of this patch
     *
     * @return string[]
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Apply method for this patch
     *
     * @return $this
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /**
         * Uses to get some random data for columns
         *
         * @var array $randomData
         */
        $randomData = $this->fillRandomDataArray();

        for ($i = 0; $i < 50; $i++) {
            $model = $this->contactUsFactory->create();
            $model
                ->setCustomerName($randomData[ContactUsInterface::NAME][rand(0, 5)])
                ->setTheme($randomData[ContactUsInterface::THEME][rand(0, 5)])
                ->setMessage($randomData[ContactUsInterface::MESSAGE][rand(0, 5)])
                ->setEmail($randomData[ContactUsInterface::EMAIL][rand(0, 5)])
                ->setStatus(ContactUsInterface::NEW_MESSAGE_STATUS)
                ->setIsAdmin(false)
                ->setPhone($randomData[ContactUsInterface::PHONE][rand(0, 5)]);
            $replyId = $this->contactUsRepository->save($model)->getId();
            for ($j = 0; $j < rand(1, 4); $j++) {
                $replyModel = $this->contactUsFactory->create();
                $replyModel
                    ->setIsAdmin(true)
                    ->setReplyId($replyId)
                    ->setMessage($this->getRandomAnswer())
                    ->setTheme($model->getTheme());
                $this->contactUsRepository->save($replyModel);
            }
        }

        $this->moduleDataSetup->getConnection()->endSetup();
        return $this;
    }

    /**
     * Fill random data array
     * All arrays have 6 elements
     *
     * @return string[][]
     */
    protected function fillRandomDataArray()
    {
        return [
            ContactUsInterface::NAME => [
                'Andrew', 'Max', 'Anton', 'Kate', 'Vitaliy', 'Mariya'
            ],
            ContactUsInterface::THEME => [
                'First', 'Second', 'Third', 'Fourth', 'Fifth', 'Sixth'
            ],
            ContactUsInterface::MESSAGE => [
                'All ok', 'Test message', 'The best shop in the world', 'Will you give answer?', 'BlaBlaBla', 'Test request'
            ],
            ContactUsInterface::EMAIL => [
                'test@mail.com', 'vasya1991@gmail.com', 'blalbalba@test.com', 'MyNaMeIsAnDrEw@email.ua', 'nooooo@gmail.com', 'fifa@football.org'
            ],
            ContactUsInterface::PHONE => [
                '+380988196258', '+380975073588', '+380955716854', '+380965714259', '+380975148322', '+380684152790'
            ]
        ];
    }

    /**
     * Returns random admin answer
     *
     * @return string
     */
    protected function getRandomAnswer()
    {
        $randomAnswerArray = [
            'Thanks for answer',
            'Fixed, can I help you with anything else?',
            'Sorry for this trouble, it will bi fixed in the shortest possible time',
            'Thanks for your mark',
            'Can you give me order id?',
            'Best wishes, good bye'
        ];
        return $randomAnswerArray[rand(0, 5)];
    }
}
