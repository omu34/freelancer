<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LinkedInController extends Controller
{
    /**
     * Retrieve LinkedIn profile data.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLinkedInProfileData(Request $request)
    {
        try {
            // Validate the access token
            $accessToken = $request->header('Authorization');
            if (empty($accessToken)) {
                return response()->json(['error' => 'Access token is missing.'], 400);
            }

            // LinkedIn API URL to retrieve profile data
            $url = 'https://www.linkedin.com/developers/tools/oauth/redirect';

            // Create a Guzzle HTTP client
            $client = new Client();

            // Make a GET request to LinkedIn API
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => $accessToken,
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                ],
            ]);

            // Get the response body content
            $data = $response->getBody()->getContents();

            // Decode the JSON data
            $jsonData = json_decode($data, true);

            // Check if the response is successful
            if ($response->getStatusCode() === 200) {
                // Return the profile data
                return response()->json($jsonData);
            } else {
                // Return an error response with the status code
                return response()->json(['error' => 'Failed to retrieve profile data.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            // Return a generic error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
