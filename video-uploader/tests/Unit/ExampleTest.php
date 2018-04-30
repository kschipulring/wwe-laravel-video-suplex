<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use GuzzleHttp\Client;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);


		$client = new Client([
			// Base URI is used with relative requests
			'base_uri' => 'http://wwe-laravel-video-suplex.3ringprototype.local/',
			// You can set any number of default request options.
			'timeout'  => 20.0,
		]);

		/*
		$request = $client->createRequest($method, $uri, null, $this->requestPayload);
		$response = $client->send($request);

		//$xml = $response->xml(); // For XML response
		//$json = $response->json(); // For JSON response
		$html = $response->getBody(); // For plain text or HTML response
*/

		$response = $client->request('GET', '/');

		$html = $response->getBody(true)->getContents();

		//var_dump( $html );


		# Create a DOM parser object
		$dom = new \DOMDocument();

		# Parse the HTML from Google.
		# The @ before the method call suppresses any warnings that
		# loadHTML might throw because of invalid HTML in the page.
		@$dom->loadHTML($html);

		# Iterate over all the <a> tags
		foreach($dom->getElementsByTagName('a') as $link) {
			# Show the <a href>
			echo $link->getAttribute('href');
			echo "<br />\n";
		}
    }
}
