<?php


namespace Enco\UrlHistory\Model;


use Enco\UrlHistory\Api\Data\UrlHistoryInterface;
use Magento\Framework\Model\AbstractModel;

use Enco\UrlHistory\Model\ResourceModel\UrlHistory as ResourceModel;


class UrlHistory extends AbstractModel implements UrlHistoryInterface
{

    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel::class);
        $this->setIdFieldName(UrlHistoryInterface::ID);
    }

    /**
     * Get Customer ID
     * @return int|null
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(UrlHistoryInterface::CUSTOMER_ID);
    }

    /**
     * Get Visited Url
     * @return string
     */
    public function getVisitedUrl(): string
    {
        return $this->getData(UrlHistoryInterface::VISITED_URL);
    }

    /**
     * Get Created At
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(UrlHistoryInterface::CREATED_AT);

    }

    /**
     * Is Active
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getData(UrlHistoryInterface::IS_ACTIVE);
    }

    /**
     * Set Customer ID
     * @param int $id
     * @return UrlHistoryInterface
     */
    public function setCustomerId(int $id): UrlHistoryInterface
    {
        return $this->setData(UrlHistoryInterface::CUSTOMER_ID, $id);
    }

    /**
     * Set Visited URL
     * @param string $url
     * @return UrlHistoryInterface
     */
    public function setVisitedUrl(string $url): UrlHistoryInterface
    {
        return $this->setData(UrlHistoryInterface::VISITED_URL, $url);
    }

    /**
     * Set Created At
     * @param string $createdAt
     * @return UrlHistoryInterface
     */
    public function setCreatedAt(string $createdAt): UrlHistoryInterface
    {
        return $this->setData(UrlHistoryInterface::CREATED_AT, $createdAt);
    }

    /**
     * Set Is Active state
     * @param bool $isActive
     * @return UrlHistoryInterface
     */
    public function setIsActive(bool $isActive): UrlHistoryInterface
    {
        return $this->setData(UrlHistoryInterface::IS_ACTIVE, $isActive);
    }
}
