<?php

namespace app;

abstract class Decorator implements DataProviderInterface{

    /**
     * @var DataProviderInterface
     */
    protected $wrapped;

    /**
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->wrapped = $dataProvider;
    }
}