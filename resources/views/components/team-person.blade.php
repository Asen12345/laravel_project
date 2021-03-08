@if ($user)
<div class="profile profile-base @if ($alg == 'center') profile-center2 @endif @if ($alg == 'right') profile-alt @endif @if ($size == 'big') profile-lg @endif @if ($size == 'middle') profile-md @endif @if ($size == 'mini') profile-sm @endif ">
	<div class="profile_pic">
		<div class="avatar @if ($size == 'big') avatar-lg @endif @if ($size == 'middle') avatar-md @endif @if ($size == 'mini') avatar-sm @endif avatar-active">

			<a href="#" role="button" id="dropdownMenuLink{{ $user->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="avatar_wrapper notAjax @if ($user->binar AND $user->binar->activated) avatar_wrapper_blue @endif">
				@if ($user->getMedia('avatars')->first())
				<img width="120" height="120" class="avatar_image" src="{{ $user->getMedia('avatars')->first()->getUrl('thumb_big') }}">
				@else
				<img width="120" height="120" class="avatar_image" src="{{ asset('theme/img/man.jpeg') }}">
				@endif
			</a>

			@if (!$main)
			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $user->id }}">
				<a class="dropdown-item" href="{{ route('team', ['user' => $user->id]) }}">{{ __('Show structure') }}</a>
				@if ($user->binar)
				@if ($user->binar AND $user->binar->redirect())
				<a class="dropdown-item" href="{{ route('remove_redirect', ['binar_id' => $user->binar->id]) }}">{{ __('Remove redirect') }}</a>
				@else
				<a class="dropdown-item" href="{{ route('set_redirect', ['binar_id' => $user->binar->id]) }}">{{ __('Set redirect') }}</a>
				@endif
				@endif
			</div>
			@endif

			@if ($user->binar AND $user->binar->redirect())
			<span class="set_redirect">
				<i class="fas fa-share"></i>
			</span>
			@endif

			<span class="avatar_caption qualify @if ($user->binar AND $user->binar->activated) qualify_blue @endif">
				@if ($user->binar)
				@if ($user->binar->type == 1)
				Std
				@endif
				@if ($user->binar->type == 2)
				Gld
				@endif
				@if ($user->binar->type == 3)
				VIP
				@endif
				@else
				–
				@endif
			</span>

			@if ($size == 'big')
			<canvas height="108" width="108"></canvas>
			@endif

			@if ($size == 'middle')
			<canvas height="82" width="82"></canvas>
			@endif

			@if ($size == 'mini')
			<canvas height="64" width="64"></canvas>
			@endif

		</div>
	</div>
	<div class="profile_info">


		<div class="dropdown">

			<a class="profile_info__name" href="#" role="button" id="dropdownMenuLink{{ $user->id }}_2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span>{{ $user->first_name }}</span>
				<span>{{ $user->last_name }}</span>
			</a>

			@if (!$main)
			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $user->id }}_2">
				<a class="dropdown-item" href="{{ route('team', ['user' => $user->id]) }}">{{ __('Show structure') }}</a>
				@if ($user->binar)
				@if ($user->binar AND $user->binar->redirect())
				<a class="dropdown-item" href="{{ route('remove_redirect', ['binar_id' => $user->binar->id]) }}">{{ __('Remove redirect') }}</a>
				@else
				<a class="dropdown-item" href="{{ route('set_redirect', ['binar_id' => $user->binar->id]) }}">{{ __('Set redirect') }}</a>
				@endif
				@endif
			</div>
			@endif
		</div>



	</div>
</div>
@else
<div class="profile profile-base @if ($alg == 'center') profile-center2 @endif @if ($alg == 'right') profile-alt @endif @if ($size == 'big') profile-lg @endif @if ($size == 'middle') profile-md @endif @if ($size == 'mini') profile-sm @endif ">
	<div class="profile_pic">
		<div class="avatar @if ($alg == 'right') avatar-alt @endif @if ($size == 'big') avatar-lg @endif @if ($size == 'middle') avatar-md @endif @if ($size == 'mini') avatar-sm @endif avatar-inactive avatar-empty">
			<span class="avatar_wrapper ">
				<div class="avatar-lock">
					<i class="fas fa-lock"></i>
				</div>
			</span>

			@if ($size == 'big')
			<canvas height="108" width="108"></canvas>
			@endif

			@if ($size == 'middle')
			<canvas height="82" width="82"></canvas>
			@endif

			@if ($size == 'mini')
			<canvas height="64" width="64"></canvas>
			@endif
		</div>
	</div>
	<div class="profile_info">
		<div class="dropdown">
			<div class="profile_info__name">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
</div>

@endif