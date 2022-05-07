<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertResponseStatus(200);
    }

        /**
     * A basic test example.
     *
     * @return void
     */
    public function testCityRouteTest()
    {
        $this->get("api/v1/city", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'success',
                'status',
                'message'
            ]
        );
    }

    public function testWeatherRouteExample()
    {
        $parameters = ['name' => 'manchester'];
        $this->post('api/v1/city/create', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
                [
                    'success',
                    'status',
                    'message',
                    'data' => [
                        'name',
                        'lat',
                        'lon',
                        'country',
                        'state',
                        'id'
                    ]
                ]
            );
    }
}
