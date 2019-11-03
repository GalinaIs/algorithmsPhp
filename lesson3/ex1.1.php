<?php

$connect = mysqli_connect('localhost', 'root', 'Ufkz1989', 'algorithm', 3307);

$query = 'select tmp.child_id as id, tmp.level, tmp.parent_id, categories_db.category_name from
(select child_id, level, max(parent_id) as parent_id from category_links group by child_id) as tmp
left join categories_db
on tmp.child_id = categories_db.id_category';

$result = mysqli_query($connect, $query);

$cats = [];
while ($cat = mysqli_fetch_assoc($result)) {
    $cats[$cat['level']][$cat['parent_id']] = $cat;
}
mysqli_close($connect);


function buildTree($cats, $level = 0, $id = 1)
{
    if (is_array($cats) && isset($cats[$level])) {
        $tree = '<ul>';
        foreach ($cats[$level] as $cat) {
            if ($cat['parent_id'] == $cat['id']) {
                $tree .= '<li>'.$cat['category_name'];
                $tree .= buildTree($cats, $level + 1, $cat['id']);
                $tree .= '</li>';
            } else if ($id == $cat['parent_id']) {
                $tree .= '<li>'.$cat['category_name'].'</li>';
            }
        }
        $tree .= '</ul>';

        return $tree;
    }
}

echo buildTree($cats);
