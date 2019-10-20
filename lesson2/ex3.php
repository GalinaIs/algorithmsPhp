<?php

function sortArray($array)
{
    if (count($array) <= 1) {
        return $array;
    }

    $left = array_slice($array, 0, count($array) / 2);
    $right = array_slice($array, count($array) / 2);

    $left = sortArray($left);
    $right = sortArray($right);

    return mergeArray($left, $right);
}

function mergeArray($left, $right)
{
    $resultArray = [];
    $positionLeft = 0;
    $positionRight = 0;

    for ($i = 0; $i < (count($left) + count($right)); $i++) {
        if ($positionLeft == count($left)) {
            $resultArray[] = $right[$positionRight];
            ++$positionRight;
        } else if ($positionRight == count($right)) {
            $resultArray[] = $left[$positionLeft];
            ++$positionLeft;
        } else if ($left[$positionLeft] < $right[$positionRight]) {
            $resultArray[] = $left[$positionLeft];
            ++$positionLeft;
        } else {
            $resultArray[] = $right[$positionRight];
            ++$positionRight;
        }
    }

    return $resultArray;
}

$array = [5, 3, 2, 1, 4];
print_r(sortArray($array));