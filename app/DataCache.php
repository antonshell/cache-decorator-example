<?php

namespace app;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Class DataCache
 * @package app
 */
class DataCache extends Decorator{

    public $cache;
    public $logger;

    /**
     * DataCache constructor.
     * @param DataProviderInterface $dataProvider
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cache)
    {
        parent::__construct($dataProvider);
        $this->cache = $cache;
        $this->logger = new DummyLogger();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param $input array
     * @return array
     */
    public function getResponse($input)
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = $this->wrapped->getResponse($input);

            $expiresAt = (new \DateTime())->modify('+1 day');

            $cacheItem->set($result);
            $cacheItem->expiresAt($expiresAt);

            return $result;
        } catch (\Exception $e) {
            $this->logger->critical('Error');
        }

        return [];
    }

    public function getCacheKey(array $input)
    {
        return md5(json_encode($input));
    }

}