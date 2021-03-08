@extends('layouts.panel')

@section('content')





@if ($user->binar)

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Team scheme') }}</h1>
	@if ($user->binar->type != 3)
	<button data-toggle="modal" data-target="#exampleModal" class="btn btn-success">{{ __('Update') }}</button>
	@endif
</div>

@if (session('status'))
<div class="alert @if (session('status') == 'success') alert-success @endif    @if (session('status') == 'error') alert-danger @endif" role="alert">
	{{ session('alert') }}
</div>
@endif

<div class="row my-3">
	<div class="col-md-12 text-center">
		<div style="display: inline-block;">
			<x-team-person :user="$user" alg="center" size="big" :main="true"></x-team-person>
		</div>
	</div>
</div>

<div class="row mb-4">
	<!-- binar_structure -->
	<div class="col-md-6 binar_structure-left">
		<div class="card">
			<div class="card-header d-md-flex justify-content-between py-3">

				<div class="team_title">{{ __('Left command') }} <span>{{ $user->binar->left_command }}</span></div>
				<div class="d-md-flex justify-content-between">


					@if ($user->binar->type == 3)
					<div class="team_points mr-4">{{ __('Points') }}: <span>{{ $user->binar->left_pv }}</span></div>
					@else
					<div class="team_points mr-4">{{ __('Points (Lost)') }}: <span>{{ $user->binar->left_pv }} ({{ $user->binar->left_lost }})</span></div>
					@endif

					<div class="team_partners">{{ __('Partners') }}: <span>{{ $user->binar->left_partners }}</span></div>
				</div>

			</div>
			<div class="card-body">

				<div class="binar_structure__body">

					<div class="binar_line">
						<div class="binar_line__item">
							@php ($left_user = ($user AND $user->binar AND $user->binar->left_user()) ? $user->binar->left_user() : null)
							<x-team-person :user="$left_user" alg="left"></x-team-person>
							<div class="binar_line__next"></div>
						</div>
					</div>

					<div class="binar_line">
						<div class="binar_line__item">
							@php ($left_user_middle_left = ($left_user AND $left_user->binar AND $left_user->binar->left_user()) ? $left_user->binar->left_user() : null)
							<x-team-person :user="$left_user_middle_left" alg="left" size="middle"></x-team-person>
							<div class="binar_line__next"></div>
						</div>

						<div class="binar_line__item">
							@php ($left_user_middle_right = ($left_user AND $left_user->binar AND $left_user->binar->right_user()) ? $left_user->binar->right_user() : null)
							<x-team-person :user="$left_user_middle_right" alg="left" size="middle"></x-team-person>
							<div class="binar_line__next"></div>
						</div>
					</div>

					<div class="binar_line">
						<div class="binar_line__item">
							@php ($left_user_middle_left_mini_left = ($left_user_middle_left AND $left_user_middle_left->binar AND $left_user_middle_left->binar->left_user()) ? $left_user_middle_left->binar->left_user() : null)
							<x-team-person :user="$left_user_middle_left_mini_left" alg="left" size="mini"></x-team-person>
						</div>

						<div class="binar_line__item">
							@php ($left_user_middle_left_mini_right = ($left_user_middle_left AND $left_user_middle_left->binar AND $left_user_middle_left->binar->right_user()) ? $left_user_middle_left->binar->right_user() : null)
							<x-team-person :user="$left_user_middle_left_mini_right" alg="left" size="mini"></x-team-person>
						</div>

						<div class="binar_line__item">
							@php ($left_user_middle_right_mini_left = ($left_user_middle_right AND $left_user_middle_right->binar AND $left_user_middle_right->binar->left_user()) ? $left_user_middle_right->binar->left_user() : null)
							<x-team-person :user="$left_user_middle_right_mini_left" alg="left" size="mini"></x-team-person>
						</div>

						<div class="binar_line__item">
							@php ($left_user_middle_right_mini_right = ($left_user_middle_right AND $left_user_middle_right->binar AND $left_user_middle_right->binar->right_user()) ? $left_user_middle_right->binar->right_user() : null)
							<x-team-person :user="$left_user_middle_right_mini_right" alg="left" size="mini"></x-team-person>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>



	<div class="col-md-6 binar_structure-right">
		<div class="card">
			<div class="card-header d-md-flex justify-content-between py-3">

				<div class="team_title">{{ __('Right command') }} <span>{{ $user->binar->right_command }}</span></div>
				<div class="d-md-flex justify-content-between">

					@if ($user->binar->type == 3)
					<div class="team_points mr-4">{{ __('Points') }}: <span>{{ $user->binar->right_pv }}</span></div>
					@else
					<div class="team_points mr-4">{{ __('Points (Lost)') }}: <span>{{ $user->binar->right_pv }} ({{ $user->binar->right_lost }})</span></div>
					@endif

					<div class="team_partners">{{ __('Partners') }}: <span>{{ $user->binar->right_partners }}</span></div>
				</div>

			</div>
			<div class="card-body">

				<div class="binar_structure__body">

					<div class="binar_line">
						<div class="binar_line__item">
							@php ($right_user = ($user AND $user->binar AND $user->binar->right_user()) ? $user->binar->right_user() : null)
							<x-team-person :user="$right_user" alg="right"></x-team-person>
							<div class="binar_line__next"></div>
						</div>
					</div>

					<div class="binar_line">
						<div class="binar_line__item">
							@php ($right_user_middle_left = ($right_user AND $right_user->binar AND $right_user->binar->left_user()) ? $right_user->binar->left_user() : null)
							<x-team-person :user="$right_user_middle_left" alg="right" size="middle"></x-team-person>
							<div class="binar_line__next"></div>
						</div>

						<div class="binar_line__item">
							@php ($right_user_middle_right = ($right_user AND $left_user->binar AND $right_user->binar->right_user()) ? $right_user->binar->right_user() : null)
							<x-team-person :user="$right_user_middle_right" alg="right" size="middle"></x-team-person>
							<div class="binar_line__next"></div>
						</div>
					</div>

					<div class="binar_line">
						<div class="binar_line__item">
							@php ($right_user_middle_left_mini_left = ($right_user_middle_left AND $right_user_middle_left->binar AND $right_user_middle_left->binar->left_user()) ? $right_user_middle_left->binar->left_user() : null)
							<x-team-person :user="$right_user_middle_left_mini_left" alg="right" size="mini"></x-team-person>
						</div>

						<div class="binar_line__item">
							@php ($right_user_middle_left_mini_right = ($right_user_middle_left AND $right_user_middle_left->binar AND $right_user_middle_left->binar->right_user()) ? $right_user_middle_left->binar->right_user() : null)
							<x-team-person :user="$right_user_middle_left_mini_right" alg="right" size="mini"></x-team-person>
						</div>

						<div class="binar_line__item">
							@php ($right_user_middle_right_mini_left = ($right_user_middle_right AND $right_user_middle_right->binar AND $right_user_middle_right->binar->left_user()) ? $right_user_middle_right->binar->left_user() : null)
							<x-team-person :user="$right_user_middle_right_mini_left" alg="right" size="mini"></x-team-person>
						</div>

						<div class="binar_line__item">
							@php ($right_user_middle_right_mini_right = ($right_user_middle_right AND $right_user_middle_right->binar AND $right_user_middle_right->binar->right_user()) ? $right_user_middle_right->binar->right_user() : null)
							<x-team-person :user="$right_user_middle_right_mini_right" alg="right" size="mini"></x-team-person>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>

</div>
<!--Row-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Update') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
@if ($user->binar->type == 1)
<form action="{{ route('update_status') }}" method="POST">
@csrf 
<div class="form-group">
	<select class="form-control" name="update">
    <option data-price="2500" value="3">VIP - 2500$</option>
    <option data-price="500" selected value="2">Gold - 500$</option>
	</select>
	<input type="hidden" name="sum" value="0">
</div>
@endif

@if ($user->binar->type == 2)
<form action="{{ route('update_status_second') }}" method="POST">
@csrf 
<div class="form-group">
	<select class="form-control" name="update">
    <option data-price="2000" selected value="3">VIP - 2000$</option>
	</select>
	<input type="hidden" name="sum" value="0">
</div>
@endif
<button type="submit" class="btn btn-success">{{ __('Update') }}</button>
</form>
			</div>
		</div>
	</div>
</div>

@else

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Affiliate program activation') }}</h1>
</div>

<div class="row">
	<div class="col-md-8">

		@if (session('status'))
		<div class="alert @if (session('status') == 'success') alert-success @endif    @if (session('status') == 'error') alert-danger @endif" role="alert">
			{{ session('alert') }}
		</div>
		@endif

		<div class="card mb-4 card-tariff">
			<div class="card-body d-sm-flex justify-content-between align-items-center">

				<div class="tariff-item mb-4 mb-sm-0">
					<img src="{{ asset('theme/img/tariffs/tariff1.png') }}" alt="{{ __('1 robot') }}">
				</div>
				<div class="tariff-item mb-4 mb-sm-0">
					<div class="tariff-item-title">{{ __('Tariff') }}:</div>
					<div class="tariff-item-value">{{ __('1 robot') }}</div>
				</div>
				<div class="tariff-item tariff-status mb-4 mb-sm-0">
					<div class="tariff-item-title">{{ __('Partner status') }}:</div>
					<div class="tariff-item-value">{{ __('Standart') }}</div>
				</div>
				<div class="tariff-item tariff-amount mb-4 mb-sm-0">500 $</div>
				<div class="tariff-item">
					<a href="{{ route('activate', ['type' => 1]) }}" class="btn btn-success">{{ __('Activate') }}</a>
				</div>

			</div>
		</div>

		<div class="card mb-4 card-tariff">
			<div class="card-body d-sm-flex justify-content-between align-items-center">

				<div class="tariff-item mb-4 mb-sm-0">
					<img src="{{ asset('theme/img/tariffs/tariff2.png') }}" alt="{{ __('4 robots') }}">
				</div>
				<div class="tariff-item mb-4 mb-sm-0">
					<div class="tariff-item-title">{{ __('Tariff') }}:</div>
					<div class="tariff-item-value">{{ __('4 robots') }}</div>
				</div>
				<div class="tariff-item tariff-status mb-4 mb-sm-0">
					<div class="tariff-item-title">{{ __('Partner status') }}:</div>
					<div class="tariff-item-value">{{ __('Gold') }}</div>
				</div>
				<div class="tariff-item tariff-amount mb-4 mb-sm-0">1 000 $</div>
				<div class="tariff-item">
					<a href="{{ route('activate', ['type' => 2]) }}" class="btn btn-success">{{ __('Activate') }}</a>
				</div>

			</div>
		</div>


		<div class="card mb-4 card-tariff">
			<div class="card-body d-sm-flex justify-content-between align-items-center">

				<div class="tariff-item mb-4 mb-sm-0">
					<img src="{{ asset('theme/img/tariffs/tariff3.png') }}" alt="{{ __('15 robots') }}">
				</div>
				<div class="tariff-item mb-4 mb-sm-0">
					<div class="tariff-item-title">{{ __('Tariff') }}:</div>
					<div class="tariff-item-value">{{ __('15 robots') }}</div>
				</div>
				<div class="tariff-item tariff-status mb-4 mb-sm-0">
					<div class="tariff-item-title">{{ __('Partner status') }}:</div>
					<div class="tariff-item-value">{{ __('VIP') }}</div>
				</div>
				<div class="tariff-item tariff-amount mb-4 mb-sm-0">
					3 000 $
					<span>+ VPS сервер на год<br />в подарок</span>
				</div>
				<div class="tariff-item">
					<a href="{{ route('activate', ['type' => 3]) }}" class="btn btn-success">{{ __('Activate') }}</a>
				</div>

			</div>
		</div>

	</div>
	<div class="col-md-4 text-center mb-4">
		<img src="{{ asset('theme/img/gift_vps.png') }}" alt="">
	</div>
</div>

@endif

@endsection

@section('scripts')

<script>
	if($("select[name='update']")){
		$("input[name='sum']").val($("select[name='update'] option:selected").data('price'));
		$("select[name='update']").change(function(){
		$("input[name='sum']").val($("select[name='update'] option:selected").data('price'));
		});
	}
</script>

@endsection