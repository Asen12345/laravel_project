<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
	/**
	 * Build the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$verificationUrl = $this->verificationUrl($notifiable);

		if (static::$toMailCallback) {
			return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
		}

		return (new MailMessage)
			// ->subject(Lang::get('Подтверждение адреса эл. почты'))
			// ->line(Lang::get('Для подтверждения адреса электронной почты нажмите на кнопку "Подтвердить"'))
			// ->action(Lang::get('Подтвердить'), $verificationUrl)
			// ->line(Lang::get('Если это не вы регистрировались - оставьте письмо без ответа'));

			->subject(Lang::get('Verify Email Address'))
			->line(Lang::get('Please click the button below to verify your email address.'))
			->action(Lang::get('Verify E-mail'), $verificationUrl)
			->line(Lang::get('If you did not create an account, no further action is required.'));
	}
}
