@extends('layouts.panel')

@section('content')

<!-- @if (session('status'))
<div class="alert alert-success" role="alert">
	{{ session('status') }}
</div>
@endif -->


<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Promo materials') }}</h1>
</div>


<div class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" id="toast" data-delay="2000" style="position: absolute; top: 85px; right: 20px; z-index: 10000;">
	<div class="toast-header">
		<svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
			<rect width="100%" height="100%" fill="#007aff"></rect>
		</svg>

		<strong class="mr-auto">{{ __('Copying') }}</strong>
		<!-- <small>только что</small> -->
		<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="toast-body">
		{{ __('Successfully!') }}
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="card mb-4">
			<!-- <div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Promo materials') }}</h6>
			</div> -->

			<div class="card-body">


				<div class="form-group">
					<label for="vk">{{ __('Partner link') }}</label>

					<div class="input-group is-invalid">
						<input id="ref_link" type="text" class="form-control" value="{{ auth()->user()->ref('ref_link') }}">
						<div class="input-group-append">
							<button class="btn btn-outline-secondary" type="button" onclick="copytext('#ref_link')">{{ __('Copy') }}</button>
						</div>
					</div>

				</div>


			</div>
		</div>

		@if ($user->binar)
		<div class="card mb-4">
			<!-- <div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Promo materials') }}</h6>
			</div> -->

			<div class="card-body">

			<div class="form-group">
				
				<div class="input-group is-invalid">
					<input id="first_ref" type="text" class="form-control" value="{{ auth()->user()->ref('first_ref') }}">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" onclick="copytext('#first_ref')">{{ __('Copy') }}</button>
					</div>
				</div>

			</div>
			
			@if ($user->binar->type == 3)

				<div class="form-group">
				
				<div class="input-group is-invalid">
					<input id="second_ref" type="text" class="form-control" value="{{ auth()->user()->ref('second_ref') }}">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" onclick="copytext('#second_ref')">{{ __('Copy') }}</button>
					</div>
				</div>

			</div>
			@endif
			@if ($user->binar->type == 2 || $user->binar->type == 3)
			<div class="form-group">
				
				<div class="input-group is-invalid">
					<input id="thr_ref" type="text" class="form-control" value="{{ auth()->user()->ref('thr_ref') }}">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" onclick="copytext('#thr_ref')">{{ __('Copy') }}</button>
					</div>
				</div>

			</div>
			@endif


			</div>
		</div>
		@endif

		<div class="card mb-4">
			<div class="card-header">
				<h6 class="m-0 font-weight-bold text-primary pt-3">{{ __('Promo materials') }}</h6>
				<!-- {{ __('Capture pages') }} -->
			</div>

			<div class="card-body">


				@forelse ($promo as $p)
				<div class="mt-3 d-flex flex-row align-items-center justify-content-between">
					<h5 class="">{{ $p->title }}</h5>
					@if ($p->getFirstMediaUrl('zips'))
					<a class="btn btn-success" download target="_blank" href="{{ $p->getFirstMediaUrl('zips') }}">{{ __('Download') }}</a>
					@endif
				</div>

				@empty
				<p>{{ __('No promo') }}</p>
				@endforelse




				{{--
				<!-- <div class="form-group">
					<label for="vk">{{ __('Partner link') }}</label>

				<div class="input-group is-invalid">
					<input id="ref_link" type="text" class="form-control" value="{{ auth()->user()->ref() }}">
					<div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" onclick="copytext('#ref_link')">{{ __('Copy') }}</button>
					</div>
				</div>

			</div> -->
			--}}


		</div>
	</div>

</div>
</div>
@endsection



@section('scripts')
<script>
	function copytext(el) {
		var $tmp = $("<textarea>");
		$("body").append($tmp);
		$tmp.val($(el).val()).select();
		document.execCommand("copy");
		$tmp.remove();

		$('#toast').toast('show');
	}
</script>
@endsection