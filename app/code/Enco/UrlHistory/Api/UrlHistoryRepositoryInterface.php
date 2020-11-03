<?php

namespace Enco\UrlHistory\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface UrlHistoryRepositoryInterface
{
    public function getById(int $id);

    public function getByUrl(string $url);

    public function getList(SearchCriteriaInterface $searchCriteria);

    public function deleteById(int $id);

    public function delete(Data\UrlHistoryInterface $model);

    public function save(Data\UrlHistoryInterface $model);
}
