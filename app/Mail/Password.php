<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class Password extends Mailable
{
	use Queueable, SerializesModels;

	protected $password;
	protected $user;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, $password)
	{
		$this->user = $user;
		$this->password = $password;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('mail.password')
			->subject(__('We have registered you in the MagnumSK system'))->with([
				'user' => $this->user,
				'password' => $this->password,
			]);
	}
}
