<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\ResetRequest;
use App\Notifications\ResetNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB as Database;
use App\Models\{User, Verification};
use App\Services\ResetService;
use \Exception;


class ResetController extends Controller
{

    /**
     * Fields requiring reset;
     */
    public $types = ['password', 'phone'];

    /**
    * Verify email or phone
    * @param json
    */
    public function process(ResetRequest $request)
    {
        try {
            ResetService::create($request->validated(), $user);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => 'Operation failed'
            ]);
        }  
    }

}












