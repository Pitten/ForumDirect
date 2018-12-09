<?php

foreach(array_slice($query->toArray(),1) as $key=>$value)
{
    if(count($query->toArray()) > 1 && $value->id == $tid) echo "yes";
}

?>