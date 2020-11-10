<?php
/**
 * Interface for Repository of UrlHistory
 * @category Smile
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\UrlHistory\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface UrlHistoryRepositoryInterface
 * @package Enco\UrlHistory\Api
 */
interface UrlHistoryRepositoryInterface
{
    public function getById(int $id);

    public function getByUrl(string $url);

    public function getList(SearchCriteriaInterface $searchCriteria);

    public function getListWithCustomer(SearchCriteriaInterface $searchCriteria);

    public function deleteById(int $id);

    public function getByName(?string $name);

    public function delete(Data\UrlHistoryInterface $model);

    public function save(Data\UrlHistoryInterface $model);
}
