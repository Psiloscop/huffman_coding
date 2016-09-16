<?php

include 'Node.php';
include 'Charted_node.php';

class Tree
{
    private $root;

    private $table;

    private $code;
    private $message;

    private $image;
    private $color;
    private $x_coordinate;

    private $top_border;
    private $bottom_border;
    private $left_border;
    private $right_border;

    private $x_shift = 35;
    private $y_shift = 50;

    public function __construct($node)
    {
        $this->root = $node;

        $this->message = '';

        $this->table = array();

        $this->x_coordinate = array();
    }

    public function get_code_table()
    {
        $this->set_code($this->root);

        return $this->table;
    }

    public function get_message($code)
    {
        $this->code = $code;

        while(!empty($this->code))
        {
            $this->get_letter($this->root);
        }

        return $this->message;
    }

    public function draw_tree()
    {
        $this->top_border = 15;
        $this->left_border = $this->right_border = 0;

        $this->set_node_coordinates($this->root, 0, $this->top_border);

        $this->image = imagecreate($this->right_border - $this->left_border - 15, $this->bottom_border + 15);

        imagecolorallocate($this->image, 255, 255, 255);

        $this->color = imagecolorallocate($this->image, 0, 0, 0);

        $this->draw_node($this->root);

        $image_name = rand(100, 999).'.png';

        imagepng($this->image, 'images/'.$image_name);

        return $image_name;
    }

    private function set_code($node, $route_to_node = '')
    {
        if(isset($node->char))
        {
            $this->table[$node->char] = $route_to_node;
        }
        else
        {
            $this->set_code($node->get_left(), $route_to_node.'0');
            $this->set_code($node->get_right(), $route_to_node.'1');
        }
    }

    private function get_letter($node)
    {
        if(isset($node->char))
        {
            $this->message .= chr($node->char);
        }
        else
        {
            if($this->code[0] == 0)
            {
                $this->code = substr($this->code, 1);

                $this->get_letter($node->get_left());
            }
            else
            {
                $this->code = substr($this->code, 1);

                $this->get_letter($node->get_right());
            }
        }
    }

    private function set_node_coordinates($node, $x, $y, $level = 1)
    {
        $x = abs($x);

        if(isset($this->x_coordinate[$level]))
        {
            $max_x = max($this->x_coordinate[$level]);

            while($x <= $max_x + $this->x_shift)
            {
                $x += $this->x_shift;
            }
        }

        if($node == NULL)
        {
            return $x;
        }

        $left_child_x = $this->set_node_coordinates(
            $node->get_left(),
            $x - $this->x_shift,
            $y + $this->y_shift,
            $level + 1
        );

        $x = $left_child_x + $this->x_shift;

        $right_child_x = $this->set_node_coordinates(
            $node->get_right(),
            $x + $this->x_shift,
            $y + $this->y_shift,
            $level + 1
        );

        if($this->left_border > $left_child_x)
        {
            $this->left_border = $left_child_x;
        }

        if($this->right_border < $right_child_x)
        {
            $this->right_border = $right_child_x;
        }

        if($this->bottom_border < $y)
        {
            $this->bottom_border = $y;
        }

        $node->x = ($left_child_x + $right_child_x) / 2;
        $node->y = $y;

        if(!isset($this->x_coordinate[$level]))
        {
            $this->x_coordinate[$level] = array();
        }

        $this->x_coordinate[$level][] = $node->x;

        return $node->x;
    }

    private function draw_node($node, $parent_x = NULL, $parent_y = NULL)
    {
        if(!isset($node))
        {
            return;
        }

        imageellipse($this->image, $node->x, $node->y, 30, 30, $this->color);

        if(isset($parent_x, $parent_y))
        {
            imageline($this->image, $parent_x, $parent_y + 15, $node->x, $node->y - 15, $this->color);
        }

        $char = isset($node->char) ? '\''.chr($node->char).'\'': '';

        imagestring($this->image, 5, $node->x - 12.5, $node->y - 8, $char, $this->color);

        $this->draw_node($node->get_left(), $node->x, $node->y);
        $this->draw_node($node->get_right(), $node->x, $node->y);
    }
}

?>
