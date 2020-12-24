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
use Exception;
use Magento\Framework\File\Csv;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class TestData implements DataPatchInterface
{
    /**#@+
     * Num of created requests
     */
    const NUM_OF_REQUESTS = 50;
    /**#@-**/

    /**#@+
     * Min and max num of answered messages to request
     */
    const MIN_ANSWER_NUM = 1;
    const MAX_ANSWER_NUM = 4;
    /**#@-**/

    /**#@+
     * Filenames of random data
     */
    const CUSTOMER_DATA_CSV_FILE = __DIR__ . "/Files/customer_data.csv";
    const ANSWER_CSV_FILE = __DIR__ . "/Files/answer_data.csv";
    /**#@-**/

    /**#@+
     * Indexes for customer data csv
     */
    const NAME_INDEX = 0;
    const THEME_INDEX = 1;
    const MESSAGE_INDEX = 2;
    const EMAIL_INDEX = 3;
    const PHONE_INDEX = 4;
    /**#@-**/

    /**#@-**/
    const ADMIN_NAME = 'Admin';
    const ADMIN_EMAIL = 'admin@smile-m2.lxc';
    /**#@-**/
    
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
     * Csv object
     *
     * @var Csv
     */
    protected $csv;

    /**
     * Array with answer data
     *
     * @var null|array $randomAnswerArray
     */
    protected $randomAnswerArray = null;

    /**
     * Array with customer data
     *
     * @var null|array $randomDataArray
     */
    protected $randomDataArray = null;

    /**
     * TestData constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ContactUsRepositoryInterface $contactUsRepository
     * @param ContactUsInterfaceFactory $contactUsFactory
     * @param Csv $csv
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ContactUsRepositoryInterface $contactUsRepository,
        ContactUsInterfaceFactory $contactUsFactory,
        Csv $csv
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->contactUsFactory = $contactUsFactory;
        $this->contactUsRepository = $contactUsRepository;
        $this->csv = $csv;
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
     * @throws Exception
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /**
         * @var array $randomData
         */
        $randomData = $this->fillRandomDataArray();
        $max = count($randomData) - 1;
        for ($i = 0; $i < self::NUM_OF_REQUESTS; $i++) {
            $model = $this->contactUsFactory->create();
            $model
                ->setCustomerName($randomData[self::NAME_INDEX][rand(0, $max)])
                ->setTheme($randomData[self::THEME_INDEX][rand(0, $max)])
                ->setMessage($randomData[self::MESSAGE_INDEX][rand(0, $max)])
                ->setEmail($randomData[self::EMAIL_INDEX][rand(0, $max)])
                ->setStatus(ContactUsInterface::NEW_MESSAGE_STATUS)
                ->setIsAdmin(false)
                ->setPhone($randomData[self::PHONE_INDEX][rand(0, $max)]);
            $replyId = $this->contactUsRepository->save($model)->getId();
            for ($j = 0; $j < rand(self::MIN_ANSWER_NUM, self::MAX_ANSWER_NUM); $j++) {
                $replyModel = $this->contactUsFactory->create();
                $replyModel
                    ->setIsAdmin(true)
                    ->setReplyId($replyId)
                    ->setCustomerName(self::ADMIN_NAME)
                    ->setEmail(self::ADMIN_EMAIL)
                    ->setMessage($this->getRandomAnswer())
                    ->setTheme($model->getTheme());
                $this->contactUsRepository->save($replyModel);
            }
        }

        $this->moduleDataSetup->getConnection()->endSetup();

        return $this;
    }

    /**
     * Fill random data array from csv
     *
     * @return string[][]
     * @throws Exception
     */
    protected function fillRandomDataArray()
    {
        if ($this->randomDataArray) {
            return $this->randomDataArray;
        }

        $this->randomDataArray = $this->csv->getData(self::CUSTOMER_DATA_CSV_FILE);

        if (!count($this->randomDataArray)) {
            throw new Exception(__("No items in file %1", self::CUSTOMER_DATA_CSV_FILE));
        }

        return $this->randomDataArray;
    }

    /**
     * Returns random admin answer from csv
     *
     * @return string
     * @throws Exception
     */
    protected function getRandomAnswer()
    {
        if (!$this->randomAnswerArray) {
            $this->randomAnswerArray = $this->csv
                ->setDelimiter(';')
                ->getData(self::ANSWER_CSV_FILE);
        }
        $count = count($this->randomAnswerArray);

        if (!$count) {
            throw new Exception(__("No items in file %1", self::ANSWER_CSV_FILE));
        }

        return $this->randomAnswerArray[rand(0, $count - 1)][0];
    }
}
