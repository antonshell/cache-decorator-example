<?php

namespace app;

/**
 * Interface DataProviderInterface
 * @package app
 */
interface DataProviderInterface{

    /**
     * @param $input array
     * @return array
     */
    public function getResponse($input);
}