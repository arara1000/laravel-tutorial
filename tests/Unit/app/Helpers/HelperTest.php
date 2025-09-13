<?php

namespace Tests\Unit\app\Helpers;

use App\Helpers\Helper;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class HelperTest extends TestCase
{
    /**
     * @test
     */
    public function full_title_helper_test(): void
    {
        assertEquals(Helper::fullTitleHelper(), 'Laravel Tutorial Sample App');
        assertEquals(Helper::fullTitleHelper('About'), 'About | Laravel Tutorial Sample App');
    }
}
