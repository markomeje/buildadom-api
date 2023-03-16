<?php

namespace App\Actions;
use App\Models\Onboarding;
use App\Http\Requests\ResetRequest;


/**
 * Like a black box
 * With one method
 * 
 */
class ResetAction 
{
	/**
	 * Handle Onboarding request
	 * 
	 * @return Onboarding model
	 */
	public function handle(ResetRequest $request): Onboarding
	{
		$onboarding = Onboarding::create($request->validated());
		return $onboarding;
	}
}