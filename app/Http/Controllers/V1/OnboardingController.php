<?php

namespace App\Http\Controllers\V1;
use App\Http\Requests\OnboardingRequest;
use App\Actions\OnboardingAction;
use App\Http\Controllers\Controller;


class OnboardingController extends Controller
{
    /**
     * Create waiting list
     * @param $request $action
     */
    public function create(OnboardingRequest $request, OnboardingAction $action)
    {
        $onboarding = $action->handle($request);
        if($onboarding) {
            return response()->json([
                'success' => true,
                'message' => 'Operation successful'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Operation failed'
        ], 500);
    }
}
