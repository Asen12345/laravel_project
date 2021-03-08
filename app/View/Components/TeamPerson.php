<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TeamPerson extends Component
{

	public $user;
	public $size;
	public $alg;
	public $main;

	/**
	 * Create a new component instance.
	 *
	 * @param $title
	 */
	public function __construct($user, $alg = 'center', $size = 'big', $main = false)
	{
		$this->user = $user;
		$this->alg = $alg;
		$this->size = $size;
		$this->main = $main;
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\View\View|string
	 */
	public function render()
	{
		return view('components.team-person');
	}
}
