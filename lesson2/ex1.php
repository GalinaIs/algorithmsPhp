<?php

function simpleDividers(int $number)
{
    $dividers = [];
    $oneDivider = 2;
    $isAppend = false;
    while ($oneDivider * $oneDivider <= $number) {
        if (0 == $number % $oneDivider) {
            if (!$isAppend) {
                $dividers[] = $oneDivider;
                $isAppend = true;
            }
            $number = $number / $oneDivider;
        } else {
            ++$oneDivider;
            $isAppend = false;
        }
    }
    if ($number > 1) {
        $dividers[] = $number;
    }
    return $dividers;
}

print_r(simpleDividers(600851475143));//все простые делители
print_r(max(simpleDividers(600851475143)));//max простой делитель

