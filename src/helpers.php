<?php

function subContent($content, $maxLength = 80)
{
    if (strlen($content) > $maxLength) {
        return mb_substr($content, 0, $maxLength) . '...';
    }

    return $content;
}