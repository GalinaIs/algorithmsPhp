<?php

function subString($inputString)
{
    $charSet = [];
    $longestSubstringOverAll = '';
    $longestSubstring = '';

    for ($i = 0; $i < mb_strlen($inputString); ++$i) {
        $char = mb_substr($inputString, $i, 1);

        if (in_array($char, $charSet)) {
            if (mb_strlen($longestSubstring) > mb_strlen($longestSubstringOverAll)) {
                $longestSubstringOverAll = $longestSubstring;
            }
            $longestSubstring = '';
            $charSet = [];
        }

        $longestSubstring .= $char;
        $charSet[] = $char;
    }

    return $longestSubstringOverAll;
}

//print_r(subString("abcabcbb") . PHP_EOL);//находим подстроку
print_r(mb_strlen(subString("abcabcbb")) . PHP_EOL);//длину подстроки подстроку

print_r(mb_strlen(subString("bbbbb")) . PHP_EOL);

print_r(mb_strlen(subString("pwwkew")) . PHP_EOL);