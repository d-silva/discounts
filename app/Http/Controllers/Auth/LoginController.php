<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;

class LoginController extends Controller {
    protected $errorMessage = 'The credentials not found in our database.';

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login( Request $request ) {
        $this->validate( $request,
            [
                'username' => 'required',
                'password' => 'required',
            ] );

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if ( ! $this->checkUser( $this->credentials( $request ) ) ) {
            return $this->sendFailedLoginResponse();
        }

        return $this->proxy( 'password', $credentials );
    }

    /**
     * Check the given user credentials.
     *
     * @return boolean
     */
    protected function checkUser( $credentials ) {
        $user = User::whereEmail( $credentials['username'] )->first();

        if ( ! is_null( $user ) && Hash::check( $credentials['password'],
                $user->password ) ) {
            return true;
        }

        return false;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials( Request $request ) {
        return $request->only( 'username', 'password' );
    }

    /**
     * Get the failed login response instance.
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse() {
        return response()->json( [
            'message' => $this->errorMessage,
        ],
            401 );
    }

    /**
     * Send request to the laravel passport.
     *
     * @param  string $grantType
     * @param  array  $data
     *
     * @return \Illuminate\Http\Response
     */
    private function proxy( $grantType, array $data = [] ) {
        try {
            $config = app()->make( 'config' );

            $data = array_merge( [
                'client_id'     => $config->get( 'secrets.client_id' ),
                'client_secret' => $config->get( 'secrets.client_secret' ),
                'grant_type'    => $grantType,
            ],
                $data );

            $http = new Client();

            $guzzleResponse = $http->post( $config->get( 'app.url' ) . '/oauth/token',
                [
                    'form_params' => $data,
                ] );
        } catch ( \GuzzleHttp\Exception\BadResponseException $e ) {
            $guzzleResponse = $e->getResponse()->getReasonPhrase();
        }
        $response = json_decode( $guzzleResponse->getBody() );

        if ( property_exists( $response, "access_token" ) ) {
            $cookie = app()->make( 'cookie' );

            $cookie->queue( 'refresh_token',
                $response->refresh_token,
                604800,
                null,
                null,
                false,
                true // HttpOnly
            );

            $response = [
                'token_type'   => $response->token_type,
                'expires_in'   => $response->expires_in,
                'access_token' => $response->access_token,
            ];
        }

        $response = response()->json( $response );
        $response->setStatusCode( $guzzleResponse->getStatusCode() );

        $headers = $guzzleResponse->getHeaders();
        foreach ( $headers as $headerType => $headerValue ) {
            $response->header( $headerType, $headerValue );
        }

        return $response;
    }

    /**
     * Handle a refresh token request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshToken( Request $request ) {
        $request = app()->make( 'request' );

        return $this->proxy( 'refresh_token',
            [
                'refresh_token' => $request->cookie( 'refresh_token' ),
            ] );
    }
}