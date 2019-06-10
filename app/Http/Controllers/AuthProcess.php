<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Lindelius\JWT\StandardJWT;
use Response;
use Validator;

class AuthProcess extends Controller
{
    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
            ],
            'verify' => false
        ]);
    }

    public function index(Request $request)
    {
    	$isbn = $request->query('isbn');
		session()->put('isbn', $isbn);
		return view('authprocess.index');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'password' => 'bail|required|string',
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        // verify login credentials
        // to be replaced with an API call to AAAS
        $apiEndpoint = 'https://api.swys.io/api/v1/user/login';
        $requestBody = [
            'email' => $email,
            'password' => $password
        ];

        try {
            $res = $this->client->request('POST', $apiEndpoint, ['json' => $requestBody]);
            $body = json_decode($res->getBody(), true);

            // inspect the response body
            // if authentication is successful, store the user's email in the session
            // modify the condition to comply with AAAS success response
            $status = $body['status'] ?? null;
            if ($status === 'success') {
                session()->put('email', $email);
                session()->put('is_member', true);
            }

            // status should either be success or error
            // if status is error, message should contain the error message
            $response = [
                'status' => $body['status'],
                'message' => $body['message']
            ];
            return Response::json($response);
        } catch (\Exception $e) {
            return Response::json(['status' => 'error', 'message' => 'unable to reach AAAS, try again later']);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'first_name' => 'bail|required|string',
            'last_name' => 'bail|required|string',
            'password' => 'bail|required|string',
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');

        // register the user
        // to be replaced with an API call to AAAS
        try {
            $res = $this->client->request('POST', 'https://yourex.ml/api/v1/user/register', [
                'json' => [
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'email' => $email,
                    'password' => $password
                ]
            ]);
            $body = json_decode($res->getBody(), true);
            $status = $body['status'] ?? null;
            if ($status === 'success') {
                session()->put('email', $email);
            }
            return Response::json($body);
        } catch (\Exception $e) {
            return Response::json(['status' => 'error', 'message' => 'unable to reach AAAS, try again later']);
        }
    }

    public function getAuthors(Request $request)
    {
        $isbn = session('isbn');
        // returns dummy data
        // to be replaced with an API call to the appropriate endpoint for getting the authors of an article by ISBN
        // $authors variable should be an array of the author full names
        $authors = ['Samuel Smith', 'Bob Baker', 'Janet Jackson'];
        return Response::json([
            'status' => 'success',
            'data' => $authors
        ]);
    }

    public function proceed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_author' => 'bail|required|boolean',
            'selected_author' => 'bail|string|nullable',
        ]);

        if ($validator->fails()) {
            return Response::json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $isAuthor = $request->input('is_author');
        $author = $request->input('selected_author');

        $isbn = session('isbn');
        $email = session('email');
        $isMember = session('is_member', false);

        // JWT encode the data to be sent back to Lumina
        $jwt = new StandardJWT();
        $jwt->exp = time() + (60 * 60); // Expire after 60 minutes
        $jwt->iat = time();
        $jwt->isbn = $isbn;
        $jwt->is_member = $isMember;
        $jwt->member_email =  $email;
        $jwt->is_author = $isAuthor;
        $jwt->author = $author;

        $accessToken = $jwt->encode(config('app.jwt_secret')); // JWT secret should be set in the .env file

        session()->flush();

        return Response::json([
            'status' => 'success',
            'data' => $accessToken
        ]);
    }
}