<?php

class PostHelper {
    static function filterPostsByCat($category) {
        $categories = array();
        $categoriesSQL = "SELECT * FROM services;";
        $res = DB::try_query($categoriesSQL);
        // associate a serviceID with a serviceName
        while ($row = mysql_fetch_assoc($res)) {
            $categories[$row['name']] = $row['id'];
        }
        $SQL = "SELECT posts.id, posts.user_id, posts.title, posts.content, posts.time, post_details.service_id FROM posts INNER JOIN post_details ON posts.id = post_details.post_id WHERE post_details.service_id = '{$categories[$category]}';";


        $options = array("filter" => "byCategory",
        "SQL" => $SQL);

        // return all posts in that category
        return Post::find("posts", $options);
    }

}

