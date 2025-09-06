<?php

namespace Tests\Feature;

use Tests\TestCase;

class StaticPagesControllerTest extends TestCase
{
    private string $base_title = 'Laravel Tutorial Sample App';

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function should_get_root(): void
    {
        $response = $this->get(route('root'));
        $response->assertStatus(200);
        $response->assertSeeHtmlInOrder(['<title>', "Home | $this->base_title", '</title>']);
    }

    /**
     * @test
     */
    public function should_get_home(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSeeHtmlInOrder(['<title>', "Home | $this->base_title", '</title>']);
    }

    /**
     * @test
     */
    public function should_get_help(): void
    {
        $response = $this->get(route('help'));
        $response->assertStatus(200);
        $response->assertSeeHtmlInOrder(['<title>', "Help | $this->base_title", '</title>']);
    }

    /**
     * @test
     */
    public function should_get_about(): void
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);
        $response->assertSeeHtmlInOrder(['<title>', "About | $this->base_title", '</title>']);
    }

    /**
     * @test
     */
    public function should_get_contact(): void
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSeeHtmlInOrder(['<title>', "Contact | $this->base_title", '</title>']);
    }
}
