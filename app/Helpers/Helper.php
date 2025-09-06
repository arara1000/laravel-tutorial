<?php

namespace App\Helpers;

class Helper
{
    public static function fullTitleHelper(string $page_title = '')
    {
        $base_title = 'Laravel Tutorial Sample App';
        if ($page_title) {
            return "$page_title | $base_title";
        }

        return 'Laravel Tutorial Sample App';
    }
}
