<?php

namespace Tests\Feature;

use Tests\TestCase;

class NosleepPageTest extends TestCase
{
    /**
     * The /nosleep page should render.
     */
    public function test_nosleep_page_returns_a_successful_response(): void
    {
        $response = $this->get('/nosleep');

        $response->assertStatus(200);
        $response->assertSee('NoSleep', false);
        $response->assertSee('Start NoSleep', false);
    }
}
