<?php
/**
 * Interface for model of Url History
 * @category Smile;
 * @package Enco\UrlHistory
 * @author Andriy Bednarskiy <bednarsasha@gmail.com>
 * @copyright 2020 Smile
 */
namespace Enco\UrlHistory\Api\Data;

/**
 * Interface UrlHistoryInterface
 * @package Enco\UrlHistory\Api\Data
 */
interface UrlHistoryInterface
{
    /**#@+
     * Fields
     */
    const ID = 'id';
    const CUSTOMER_ID = 'customer_id';
    const VISITED_URL = 'visited_url';
    const CREATED_AT = 'created_at';
    const IS_ACTIVE = 'is_active';
    /**#@-*/

    /**@!+
     * IS_ACTIVE states
     */
    const ENABLED = 1;
    const DISABLED = 0;
    /**#@- */

    public function getCustomerId() : ?int;
    public function getVisitedUrl() : string;
    public function getCreatedAt() : string;
    public function isActive() : bool;

    public function setCustomerId(int $id) : self;
    public function setVisitedUrl(string $url) : self;
    public function setCreatedAt(string $createdAt) : self;
    public function setIsActive(bool $isActive) : self;
}
