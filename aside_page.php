

<?php
    function create_aside($items_aside)
    {
        echo "<ul class= aside>";
        foreach($items_aside as $label => $path)
        {   
            echo "<li id='#{$path[0]}-aside'> <a href='{$path[1]}'>{$label}</a> </li>";
        }

        echo "</ul>";
    }
?>
