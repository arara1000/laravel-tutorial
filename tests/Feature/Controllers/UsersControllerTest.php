<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    private string $base_title = 'Laravel Tutorial Sample App';

    /**
     * @test
     */
    public function should_get_new(): void
    {
        $response = $this->get(route('signup'));
        $response->assertStatus(200);
        $response->assertSeeHtmlInOrder(['<title>', "Sign up | $this->base_title", '</title>']);
    }
}
