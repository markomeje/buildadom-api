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
            $reset = ResetService::create([
                'email' => $request->email,
                'type' => $request->type,
            ]);

            if ($reset) {
                return response()->json([
                    'success' => true,
                    'message' => 'A reset code have been sent to your email.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Operation failed'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => app()->environment(['production']) ? 'Unknown server error. Try again later.' : $error->getMessage()
            ]);
        }  
    }

    /**
    * Update
    * @param json
    */
    public function update(ResetRequest $request)
    {
        //dd($request->validated());
        try {
            $reset = ResetService::update($request->validated());
            if ($reset) {
                return response()->json([
                    'success' => true,
                    'message' => 'Operation successful.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Operation failed'
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'message' => app()->environment(['production']) ? 'Unknown server error. Try again later.' : $error->getMessage()
            ]);
        }  
    }

}












