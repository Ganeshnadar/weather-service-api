<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResponseTrait;

abstract class Controller extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
    }
    /**
     * Validate HTTP request against the rules
     *
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @return bool|array
     */
    protected function validateRequest(Request $request, array $rules, array $messages = [])
    {
        // Perform Validation
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->messages();

            $errorMessages = array_merge($errorMessages, $messages);
            // create error message by using key and value
            foreach ($errorMessages as $key => $value) {
                $errorMessages[$key] = $value[0];
            }
            return $errorMessages;
        }
        return true;
    }
}
