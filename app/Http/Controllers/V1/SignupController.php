<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\SignupRequest;
use App\Actions\SignupAction;
use App\Http\Controllers\Controller;
use \Exception;


class SignupController extends Controller
{
    /**
     * Create waiting list
     * @param $request $signup
     */
    public function signup(SignupRequest $request, SignupAction $signup)
    {
        try {
            if($signup->handle($request)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Signup successful.',
                    'response' => $signup,
                ], 201);
            }

            return response()->json([
                'success' => false,
                'message' => 'Operation failed'
            ], 500);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => $error->getMessage(),
            ], 500);
        }
            
    }
}
