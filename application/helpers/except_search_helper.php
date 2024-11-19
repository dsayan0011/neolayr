<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


function except_search($string)
{
    $onlyLetters = mb_ereg_replace('[^\\p{L}\s]', '', $string);
    $onlyLetters = preg_replace('/([\s])\1+/', ' ', $onlyLetters);
    $onlyLetters = preg_replace('/\s/', ',', trim($onlyLetters));
    return $onlyLetters;
}