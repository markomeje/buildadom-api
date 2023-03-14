<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\VerificationRequest;
use App\Actions\SignupAction;
use App\Services\VerificationService;
use App\Notifications\EmailVerificationNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB as Database;
use App\Models\{User, Verification};
use \Exception;


class VerificationController extends Controller
{

    public $types = ['email', 'phone'];


    /**
    * Verify email or phone
    * @param json
    */
    public function verify(VerificationRequest $request)
    {
        return Database::transaction(function() use ($request) {
            $verification = (new \App\Services\VerificationService());

            $type = $request->type;
            if (!in_array($type, $this->types)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification.'
                ]);
            }

            $verify = $verification->exists([
                'type' => $type,
                'code' => $request->code
            ]);

            if (empty($verify)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification code.'
                ]);
            }

            $verify->update([
                'id' => $verify->id, 
                'code' => null, 
                'verified' => true
            ]);

            if($type === 'phone') {
                $user = User::where(['id' => $verify->user_id])->first();
                Verification::where(['type' => 'email', 'user_id' => $user->id])->delete();

                $token = rand(111111, 999999);
                Verification::create([
                    'type' => 'email', 
                    'code' => $token,
                    'reference' => str()->random(64),
                    'user_id' => $user->id,
                ]);

                $user->notify(new EmailVerificationNotification($token));
                return response()->json([
                    'success' => true,
                    'message' => 'An email verification code have been sent to your email.',
                ]);
            }else {
                return response()->json([
                    'success' => true,
                    'message' => 'Verification successful.',
                    'response' => ['done' => true],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Operation failed'
            ]);
        });   
    }

}












