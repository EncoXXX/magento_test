<?php

namespace Enco\AdminBlock\Model;

use Enco\AdminBlock\Api\Data\CustomerVisitedUrlsInterface;
use Enco\AdminBlock\Model\CustomerVisitedUrls as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class CustomerVisitedUrls extends AbstractModel implements CustomerVisitedUrlsInterface
{
    public function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel::class);
        $this->setIdFieldName(CustomerVisitedUrlsInterface::ID);
    }

    public function getCustomerId(): int
    {
        return $this->getData(CustomerVisitedUrlsInterface::ID);
    }

    public function getVisitedUrl(): string
    {
        return $this->getData(CustomerVisitedUrlsInterface::VISITED_URL);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(CustomerVisitedUrlsInterface::CREATED_AT);
    }

    public function isActive(): bool
    {
        return $this->getData(CustomerVisitedUrlsInterface::IS_ACTIVE);
    }

    public function setCustomerId(int $customerId): CustomerVisitedUrlsInterface
    {
        return $this->setData(CustomerVisitedUrlsInterface::ID, $customerId);
    }

    public function setVisitedUrl(string $url): CustomerVisitedUrlsInterface
    {
        return $this->setData(CustomerVisitedUrlsInterface::VISITED_URL, $url);
    }

    public function setCreatedAt(string $createdAt): CustomerVisitedUrlsInterface
    {
        return $this->setData(CustomerVisitedUrlsInterface::CREATED_AT, $createdAt);
    }

    public function setIsActive(bool $isActive): CustomerVisitedUrlsInterface
    {
        return $this->setData(CustomerVisitedUrlsInterface::IS_ACTIVE, $isActive);
    }
}
