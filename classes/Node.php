<?php

class Node
{
    public $char;
    public $weight;

    private $left;
    private $right;

    public function __construct($weight, $char = NULL)
    {
        $this->weight = $weight;
        $this->char = $char;

        $this->left = NULL;
        $this->right = NULL;
    }

    public function get_left()
    {
        return $this->left;
    }

    public function get_right()
    {
        return $this->right;
    }

    public function insert_children($left = NULL, $right = NULL)
    {
        $this->left = $left;
        $this->right = $right;
    }
}

?>