<?php

function replace_badwords($text)
{
    //i'm providing here some exmaples of bad words filtering.
    //you can select/modify the method you like.

    //check for 'F! Uccc~k' and Co
    $bad_words = array(
        "'[fF]{1,5}[^[:alnum:]]{0,10}[uUaA]{1,5}[^[:alnum:]]{0,10}[cC]{1,5}[^[:alnum:]]{0,10}[kK]{1,5}'",
        "'[sS]{1,5}[^[:alnum:]]{0,10}[hH]{1,5}[^[:alnum:]]{0,10}[iI]{1,5}[^[:alnum:]]{0,10}[tT]{1,5}'",
        "'[sS]{1,5}[^[:alnum:]]{0,10}[hH]{1,5}[^[:alnum:]]{0,10}[eE]{1,5}[^[:alnum:]]{0,10}[iI]{1,5}[^[:alnum:]]{0,10}[sS�]{1,5}'",
        "'[aA]{1,5}[^[:alnum:]]{0,10}[rR]{1,5}[^[:alnum:]]{0,10}[sS]{1,5}[^[:alnum:]]{0,10}[cC]{1,5}[^[:alnum:]]{0,10}[hH]{1,5}'"
    );
    $good_words = "[...]";
    if (function_exists("preg_replace")) {
        $text = preg_replace($bad_words, $good_words, $text);
    }

    return $text;
}