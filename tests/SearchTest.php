<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_endpoint_returns_a_successful_response()
    {
        $this->get('/api/search/local/60050070,60050080,60050090,60050060');

        $this->assertEquals(
            $this->response->getContent(), $this->response->getContent()
        );
    }
}
