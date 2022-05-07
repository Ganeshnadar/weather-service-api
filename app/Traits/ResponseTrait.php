<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

trait ResponseTrait
{
    /**
     * HTTP response in JSON Format
     * @param bool $success - Success Status [true|false]
     * @param int $status - HTTP Status Code [eg. 200]
     * @param string $message - Response Message
     * @param array $error - Response Error
     * @param array|object $data - Response Data
     * @return \Illuminate\Http\JsonResponse $response
     */
    public function responseJson(bool $success, int $status, string $message = '', array $error = [], $data = [], $extension = []) {
        $result_data = ['data' => $data];

        return \response()->json(array_merge([
            'success'   =>  $success,
            'status'    =>  $status,
            'message'   =>  $message,
            'error'     =>  $error,
        ],$result_data, $extension), $status);
    }
}

?>
