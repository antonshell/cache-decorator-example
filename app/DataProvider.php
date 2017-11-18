<?php

namespace app;

/**
 * Class DataProvider
 * @package app
 */
class DataProvider implements DataProviderInterface{

    private $host;
    private $user;
    private $password;

    /**
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param $input array
     * @return array
     */
    public function getResponse($input)
    {
        // returns a response from external service

        sleep(5);
        return array_flip($input);
    }
}