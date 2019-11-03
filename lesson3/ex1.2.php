<?php

function isPrime($number)
{
    for ($i = 1; $i < $number / 2; $i += 2) {
        if (0 == $number % $i && 1 != $i) {
            return false;
        }
    }

    return true;
}

function findCertainPrimeNumber($count)
{
    if (1 == $count) {
        return 2;
    }

    $answer = 1;

    for ($i = 1; $i < $count;) {
        $answer += 2;
        if (isPrime($answer)) {
            ++$i;
        }
    }

    return $answer;
}

echo findCertainPrimeNumber(6).PHP_EOL;
echo findCertainPrimeNumber(10001).PHP_EOL;