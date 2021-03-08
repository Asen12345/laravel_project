@extends('layouts.panel')

@section('content')

<!-- @if (session('status'))
<div class="alert alert-success" role="alert">
	{{ session('status') }}
</div>
@endif -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Curator') }}</h1>
</div>


<div class="row justify-content-center2">
	<div class="col-md-6">
		<div class="card mb-4">
			<!-- <div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Curator') }}</h6>
			</div> -->

			<div class="card-body">


				<div class="mb-5">
					@if ($curator->getMedia('avatars')->first())
					@php ($avatar = $curator->getMedia('avatars')->first()->getUrl('thumb_middle'))
					@else
					@php ($avatar = asset('theme/img/boy.png'))
					@endif

					<div class="my-3 row">
						<div class="col-md-4">
							<img width="100" height="100" class="img-profile rounded-circle" src="{{ $avatar }}">
						</div>

						<div class="col-md-8 d-flex align-items-center">
							{{ $curator->first_name }}<br />{{ $curator->last_name }}
						</div>
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Activity') }}</div>
					<div class="col-md-8 text-right2">
						{!! $curator->status() !!}
						{{--
							@if ($curator->binar)
						@if ($curator->binar->activated)
						{{ __('Active') }}
						@else
						{{ __('Not active') }}
						@endif
						@else
						@endif
						--}}
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Tariff') }}</div>
					<div class="col-md-8 text-right2">
						@if ($curator->binar)
						@if ($curator->binar->type == 1)
						Standard
						@endif
						@if ($curator->binar->type == 2)
						Gold
						@endif
						@if ($curator->binar->type == 3)
						VIP
						@endif

						@else
						–
						@endif
					</div>
				</div>

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Referrals count') }}</div>
					<div class="col-md-8 text-right2">{{ $curator->count_partners() }}</div>
				</div>


				<div class="my-3 row">
					<div class="col-md-4">{{ __('Registration date') }}</div>
					<div class="col-md-8 text-right2">{{ date('d.m.Y', strtotime($curator->created_at)) }}</div>
				</div>


				<h4 class="mt-5 mb-4">{{ __('Contacts') }}</h4>

				<div class="my-3 row">
					<div class="col-md-4">{{ __('Email') }}</div>
					<div class="col-md-8 text-right2"><a href="mailto:{{ $curator->email }}">{{ $curator->email }}</a></div>
				</div>

				@if ($curator->phone)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('Phone') }}</div>
					<div class="col-md-8 text-right2"><a href"tel:+{{ $curator->phone }}">{{ $curator->phoneNumber() }}</a></div>
				</div>
				@endif

				@if ($curator->vk)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('Vkontakte') }}</div>
					<div class="col-md-8 text-right2"><a target="_blank" href="https://vk.com/{{ $curator->vk }}">https://vk.com/{{ $curator->vk }}</a></div>
				</div>
				@endif

				@if ($curator->instagram)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('Instagram') }}</div>
					<div class="col-md-8 text-right2">
						<a target="_blank" href="https://www.instagram.com/{{ $curator->instagram }}">https://www.instagram.com/{{ $curator->instagram }}</a>
					</div>
				</div>
				@endif

				@if ($curator->fb)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('Facebook') }}</div>
					<div class="col-md-8 text-right2">
						<a target="_blank" href="https://www.facebook.com/{{ $curator->fb }}">https://www.facebook.com/{{ $curator->fb }}</a>
					</div>
				</div>
				@endif

				@if ($curator->telegram)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('Telegram') }}</div>
					<div class="col-md-8 text-right2">
						<a target="_blank" href="https://t.me/{{ $curator->telegram }}">{{ '@' . $curator->telegram }}</a>
					</div>
				</div>
				@endif

				@if ($curator->whatsapp)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('WhatsApp') }}</div>
					<div class="col-md-8 text-right2">
						<a target="_blank" href="https://wa.me/{{ $curator->whatsapp }}">{{ $curator->whatsapp }}</a>
					</div>
				</div>
				@endif

				@if ($curator->viber)
				<div class="my-3 row">
					<div class="col-md-4">{{ __('Viber') }}</div>
					<div class="col-md-8 text-right2">
						<a target="_blank" href="viber://chat?number={{ $curator->viber }}">{{ $curator->viber }}</a>
					</div>
				</div>
				@endif



			</div>
		</div>
	</div>
</div>
@endsection