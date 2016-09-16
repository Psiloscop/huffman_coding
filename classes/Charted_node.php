<?php

class Charted_node extends Node
{
    public $x;
    public $y;

    public function __construct($weight, $char = NULL)
    {
        parent::__construct($weight, $char);
    }
}

?>