<?php

function isPalindrome($string)
{
    if (1 == strlen($string)) {
        return true;
    }

    $len = strlen($string);
    if (substr($string, 0, 1) == substr($string, $len - 1)) {
        if (2 == $len) {
            return true;
        }
        return isPalindrome(substr($string, 1, $len - 2));
    } else {
        return false;
    }
}

var_dump(isPalindrome("radar"));
var_dump(isPalindrome("abc"));
var_dump(isPalindrome("wasaw"));
