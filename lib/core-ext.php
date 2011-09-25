<?php

class DB {
    public static function try_query($query) {
        $res = mysql_query($query);
        if (!$res) {
            die("Invalid query: ({$query}) " . mysql_error());
        }
        return $res;
    }

}

// helper to flatten arrays
function flatten($array) {
    if (!is_array($array)) {
        // nothing to do if it's not an array
        return array($array);
    }

    $result = array();
    foreach ($array as $value) {
        // explode the sub-array, and add the parts
        $result = array_merge($result, flatten($value));
    }

    return $result;
}

