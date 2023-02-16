<?php

namespace App\Actions;
use App\Models\Onboarding;
use App\Http\Requests\OnboardingRequest;


/**
 * Like a black box
 * With one method
 * 
 */
class OnboardingAction 
{
	/**
	 * Handle Onboarding request
	 * 
	 * @return Onboarding model
	 */
	public function handle(OnboardingRequest $request): Onboarding
	{
		$onboarding = Onboarding::create($request->validated());
		return $onboarding;
	}
}