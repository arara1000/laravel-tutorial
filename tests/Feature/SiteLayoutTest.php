<?php

namespace Tests\Feature;

use Tests\TestCase;

class siteLayoutTest extends TestCase
{
    /**
     * @test
     */
    public function layout_links(): void
    {
        $response = $this->get(route('root'));
        $response->assertViewIs('static_pages.home');
        $response->assertSeeHtmlInOrder(['<header', 'href="'.route('root'), '</header>']);
        $response->assertSeeHtmlInOrder(['<header', 'href="'.route('help'), '</header>']);
        $response->assertSeeHtmlInOrder(['<footer', 'href="'.route('about'), '</footer>']);
        $response->assertSeeHtmlInOrder(['<footer', 'href="'.route('contact'), '</footer>']);
    }
}
