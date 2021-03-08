<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('referrer_id')->nullable();
			$table->foreign('referrer_id')->references('id')->on('users');

			$table->string('referral_code');

			$table->string('first_name');
			$table->string('last_name')->nullable();

			$table->string('telegram')->nullable();
			$table->string('whatsapp')->nullable();
			$table->string('viber')->nullable();
			$table->string('vk')->nullable();
			$table->string('fb')->nullable();
			$table->string('instagram')->nullable();

			$table->string('phone')->nullable();
			$table->string('phone_check')->nullable();
			$table->string('phone_code')->nullable();

			$table->tinyInteger('phone_code_error')->default(0)->nullable();
			$table->timestamp('phone_code_at')->nullable();

			$table->string('purse')->nullable();

			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');

			$table->enum('role', ['admin', 'manager', 'investor', 'user'])->default('user'); // Администратор, менеджер, инвестор, ну и без роли

			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
