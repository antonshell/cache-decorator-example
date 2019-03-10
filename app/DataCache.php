<?php

namespace app;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

/**
 * Class DataCache
 * @package app
 */
class DataCache extends Decorator{

    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var null|LoggerInterface
     */
    private $logger;

    /**
     * DataCache constructor.
     * @param DataProviderInterface $dataProvider
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface|null $logger
     */
    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        parent::__construct($dataProvider);
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array $input
     * @return array|mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getResponse($input)
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                $this->logger->info('Get from cache: ' . $cacheKey);
                return $cacheItem->get();
            }

            $result = $this->wrapped->getResponse($input);

            $expiresAt = (new \DateTime())->modify('+1 day');

            $cacheItem->set($result);
            $cacheItem->expiresAt($expiresAt);

            $this->logger->info('Get from source: ' . $cacheKey);

            return $result;
        } catch (\Exception $e) {
            $this->logger->critical('Error: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * @param array $input
     * @return string
     */
    public function getCacheKey(array $input)
    {
        return md5(json_encode($input));
    }

    /**
     * @param $cacheKey
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function invalidate($cacheKey){
        $this->cache->deleteItem($cacheKey);
        $this->logger->info('Remove from cache: ' . $cacheKey);
    }

}