<?php
/**
 * Created by PhpStorm.
 * User: diogosilva
 * Date: 25/09/2017
 * Time: 00:23
 */

namespace App\Http\Controllers;

class ApiController extends Controller {

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondNotFound( $message = 'Not Found!' ) {
        return $this->setStatusCode( 404 )->respondWithError( $message );
    }

    /**
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError( $message ) {
        return $this->respond( [
            'error' => [
                'message'     => $message,
                'status_code' => $this->getStatusCode(),
            ],
        ] );
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond( $data, $headers = [] ) {
        return response()->json( $data, $this->getStatusCode(), $headers );
    }

    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode( $statusCode ) {
        $this->statusCode = $statusCode;

        return $this;
    }
}