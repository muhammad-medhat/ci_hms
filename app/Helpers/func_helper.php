<?php

if(!function_exists('dump_obj')){

    function dump_obj($obj, $title=''){
        echo "<pre>";
            echo "<h4>$title</h4>";
            print_r($obj);
            echo "<ul>";
            foreach($obj as $o)
            {
                $t = gettype( $o);
                echo "<li>$t: $o</li>";
            }
            echo "</ul>";

        echo "</pre>";
    }}