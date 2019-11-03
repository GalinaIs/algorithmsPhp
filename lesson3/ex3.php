<?php

$connect = mysqli_connect('localhost', 'root', 'Ufkz1989', 'algorithm', 3307);

$query = 'SELECT nested_sets.*, catalog.name FROM nested_sets left join catalog on nested_sets.id = catalog.id';

$result = mysqli_query($connect, $query);

$cats = [];
$parents = [];
while ($cat = mysqli_fetch_assoc($result)) {
    $cats[$cat['level']][$cat['id']] = $cat;
    $parents[] = $cat;
}
mysqli_close($connect);

foreach ($cats as &$cat) {
    foreach ($cat as &$oneRecord) {
        $oneRecord['parent_id'] = 0;
        $level = $oneRecord['level'];
        foreach ($parents as $parent) {
            if ($parent['level'] == $oneRecord['level'] - 1 && $oneRecord['left'] > $parent['left'] && $oneRecord['right'] < $parent['right']) {
                $oneRecord['parent_id'] = $parent['id'];
                break;
            }
        }
    }
}

function buildTree($cats, $level = 1, $parentId = 0)
{
    if (is_array($cats) && isset($cats[$level])) {
        $tree = '<ul>';
        foreach ($cats[$level] as $cat) {
            if ($cat['parent_id'] == $parentId) {
                $tree .= '<li>'.$cat['name'];
                $tree .= buildTree($cats, $level + 1, $cat['id']);
                $tree .= '</li>';
            }
        }
        $tree .= '</ul>';

        return $tree;
    }
}

echo buildTree($cats);