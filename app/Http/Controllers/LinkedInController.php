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
            // $linked = [
            //     "https://www.linkedin.com/cws/alumni",
            //     "https://www.linkedin.com/cws/followmember",
            //     "https://www.linkedin.com/cws/settings",
            //     "https://www.linkedin.com/cws/share",

            //     "https://www.linkedin.com/countserv/count/share",
            //     "https://www.linkedin.com/cws/company/profile",

            //     "https://www.linkedin.com/cws/member/public_profile",

            //     "https://www.linkedin.com/cws/member/full_profile",
            //     "https://www.linkedin.com/cws/referral",
            //     "https://www.linkedin.com/cws/job/apply",
            //     "https://www.linkedin.com/cws/mail",

            //     "https://www.linkedin.com/countserv/count/job-apply",

            //     "https://www.linkedin.com/cws/company/insider",
            //     "https://www.linkedin.com/cws/sfdc/member",
            //     "https://www.linkedin.com/cws/sfdc/company",
            //     "https://www.linkedin.com/cws/sfdc/signal",

            //     "https://www.linkedin.com/cws/cap/recruiter_member",
            //     "https://www.linkedin.com/cws/jymbii",
            //     "https://www.linkedin.com/cws/today/today",
            //     "https://www.linkedin.com/cws/login",

            //     "https://www.linkedin.com/college/alumni-facet-extension",
            //     "https://www.linkedin.com/cws/csap/beacon",

            //     "https://www.linkedin.com/biz/{COMPANY_ID}/product?prdId={PRODUCT_ID}",

            //     "https://www.linkedin.com/biz/api/recommendation/count?type=PDCT&id={PRODUCT_ID}&callback={CALLBACK}",
            //     "https://platform.linkedin.com/xdoor/extensions/Login.js",
            //     "https://platform.linkedin.com/xdoor/extensions/Wizard.js",
            //     "https://platform.linkedin.com/xdoor/extensions/Debug.js",

            //     "https://www.linkedin.com/pages-extensions/FollowCompany.js",


            //     "https://platform.linkedin.com/xdoor/widgets/relay.html",

            //     "https://api.linkedin.com/xdoor/widgets/api/proxy.html",
            //     "https://www.linkedin.com/uas/connect/user-signin",
            //     "https://www.linkedin.com/uas/connect/logout",
            //     "https://www.linkedin.com/uas/oauth2/authorize",
            //     "https://www.linkedin.com",

            //     "https://www.linkedin.com/xdoor/widgets/user/session.html",

            //     "https://www.linkedin.com/oauth/web-pkce/authorization",

            //     "https://platform.linkedin.com/xdoor/widgets/oauth-redirect.html",

            // ];
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
