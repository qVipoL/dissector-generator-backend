<?php

class QueryParam
{
    public $param;
    public $value;

    public function __construct($param, $value)
    {
        $this->param = $param;
        $this->value = $value;
    }
}
