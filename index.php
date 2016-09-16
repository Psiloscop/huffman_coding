<?php

    $submit = isset($_POST['execute']) ? TRUE : FALSE;

    if($submit)
    {
        include 'classes/Tree.php';

        session_start();

        $input_string = $_POST['message'];
        $command = $_POST['command'];

        if($command === 'encode')
        {
            $chars = count_chars($input_string, 1);
            $nodes = array();

            uasort($chars, function($a, $b) {
                if($a == $b) {
                    return 0;
                }

                return ($a <= $b) ? -1 : 1;
            });

            foreach($chars as $char => $match)
            {
                $nodes[] = new Charted_node($match, $char);
            }

            while(count($nodes) != 1)
            {
                $new_node = new Charted_node($nodes[0]->weight + $nodes[1]->weight);

                $new_node->insert_children($nodes[0], $nodes[1]);

                array_shift($nodes);
                array_shift($nodes);

                array_unshift($nodes, $new_node);

                usort($nodes, function ($a, $b) {
                    if($a->weight == $b->weight)
                    {
                        return 0;
                    }

                    return ($a->weight <= $b->weight) ? -1 : 1;
                });

                unset($new_node);
            }

            $tree = new Tree($nodes[0]);
            $table = $tree->get_code_table();

            $_SESSION['tree'] = serialize($tree);
            $_SESSION['table'] = json_encode($table);


            $output_string = $input_string;

            foreach($table as $char => $code)
            {
                $output_string = str_replace(chr($char), $code, $output_string);
            }

            $image_path = $tree->draw_tree();
        }
        else
        {
            $tree = unserialize($_SESSION['tree']);
            $table = json_decode($_SESSION['table']);

            $output_string = $tree->get_message($input_string);
        }
    }

    require 'html/page.php';

?>