<?php

namespace Tests\Unit;

use App\Services\Booking\Entities\ShowEntity;
use App\Services\Booking\ExternalClients\LeadBookAPIClient;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LeadBookAPITest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $url = 'https://test.test/';
        $token = 'token';
        $client = new LeadBookAPIClient($url, $token);

        Http::fake([
            $url.'shows' => Http::response([
                'response' => [
                    ['id' => 1, 'name' => 'Show #1'],
                    ['id' => 2, 'name' => 'Show #2'],
                    ['id' => 3, 'name' => 'Show #3'],
                ]
            ])
        ]);

        $shows = $client->getShows();

        $expectedCollection = collect([
            new ShowEntity(id: 1, name: 'Show #1'),
            new ShowEntity(id: 2, name: 'Show #2'),
            new ShowEntity(id: 3, name: 'Show #3'),
        ]);

        $this->assertEquals($expectedCollection, $shows);

        Http::assertSent(function (Request $request) use($url, $token) {
            return $request->url() == $url.'shows'
                && $request->hasHeader('Authorization', 'Bearer '.$token);
        });
    }
}
