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
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Csv;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\SampleData\FixtureManager;

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
    const CUSTOMER_DATA_CSV_FILE = "Enco_ContactUs::fixtures/customer_data.csv";
    const ANSWER_CSV_FILE = "Enco_ContactUs::fixtures/answer_data.csv";
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
     * Fixture manager
     *
     * @var FixtureManager
     */
    protected $fixtureManager;

    /**
     * Csv object
     *
     * @var Csv
     */
    protected $csv;

    /**
     * TestData constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ContactUsRepositoryInterface $contactUsRepository
     * @param ContactUsInterfaceFactory $contactUsFactory
     * @param Csv $csv
     * @param FixtureManager $fixtureManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ContactUsRepositoryInterface $contactUsRepository,
        ContactUsInterfaceFactory $contactUsFactory,
        Csv $csv,
        FixtureManager $fixtureManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->contactUsFactory = $contactUsFactory;
        $this->contactUsRepository = $contactUsRepository;
        $this->fixtureManager = $fixtureManager;
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
                ->setCustomerName($randomData[ContactUsInterface::NAME][rand(0, $max)])
                ->setTheme($randomData[ContactUsInterface::THEME][rand(0, $max)])
                ->setMessage($randomData[ContactUsInterface::MESSAGE][rand(0, $max)])
                ->setEmail($randomData[ContactUsInterface::EMAIL][rand(0, $max)])
                ->setStatus(ContactUsInterface::NEW_MESSAGE_STATUS)
                ->setIsAdmin(false)
                ->setPhone($randomData[ContactUsInterface::PHONE][rand(0, $max)]);
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

        $this->randomDataArray = $this->getData(self::CUSTOMER_DATA_CSV_FILE);

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
        $data = $this->getData(self::ANSWER_CSV_FILE);
        $max = count($data) - 1;
        return $data["Answer"][rand(0, $max)];
    }

    /**
     * Returns data with keys from CSV
     *
     * @param $filename
     *
     * @return array
     * @throws LocalizedException
     * @throws Exception
     */
    protected function getData($filename)
    {
        $filename = $this->fixtureManager->getFixture($filename);
        $rawData = $this->csv->getData($filename);
        if (!$rawData) {
            throw new Exception(__("No items in file %1", $filename));
        }
        $headers = array_shift($rawData);
        $keyedData = [];

        foreach ($rawData as $row_index => $row) {
            foreach ($row as $column_index => $column) {
                $keyedData[$headers[$column_index]][] = $column;
            }
        }

        return $keyedData;
    }
}
