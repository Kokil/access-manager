<?php

Class UserController extends UserBaseController {

	const HOME = 'user-panel';
	
	public function getIndex()
	{

		return View::make('user.dashboard')
					->with('profile', Auth::user());
	}

	public function getRecharge()
	{
		$plans = Plan::with('limit')->paginate(10);
		return View::make('user.recharge')
					->with('plans', $plans);
	}

	public function postPinRecharge()
	{
		// pr(Input::all());
		Recharge::viaPin(Input::get('pin'), Auth::user()->id);
		return Redirect::route(self::HOME);
	}

	public function getRechargeHistory()
	{
		$rc_history = Subscriber::find(Auth::id())
								->rechargeHistory()
								->with('limits')
								->orderby('updated_at','desc')
								->paginate(10);

		return View::make('user.recharge_history')
					->with('rc_history', $rc_history);
	}

	public function getSessionHistory()
	{
		$sess_history = Subscriber::find(Auth::id())
									->sessionHistory()
									->orderby('acctstarttime','desc')
									->paginate(10);
		return View::make('user.session_history')
					->with('sess_history', $sess_history);
	}

	public function getChangePassword()
	{
		return View::make('user.change_password');
	}

	public function postChangePassword()
	{

	}

}