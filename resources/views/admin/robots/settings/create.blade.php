@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Create robot setting') }}</h1>

	<a class="btn btn-light" href="{{ route('admin.robot-settings.index', $robot) }}">
		{{ __('Back') }}
	</a>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">

			<div class="card-body">
				<form method="POST" action="{{ route('admin.robot-settings.store', $robot) }}" enctype="multipart/form-data">
					@csrf

					<div class="form-group">
						<label for="name">{{ __('Setting name') }}</label>

						<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>

						@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="symbol">{{ __('Symbol') }}</label>

						<input id="symbol" type="text" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol') }}">

						@error('symbol')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="1" name="active" id="active" {{ old('active') ? 'checked' : '' }}>

							<label class="form-check-label" for="active">
								{{ __('Active') }}
							</label>
						</div>
					</div>

					<button type="submit" class="btn btn-primary btn-block">
						{{ __('Save') }}
					</button>
				</form>
			</div>

		</div>
	</div>
</div>
<!--Row-->

<style>
	.custom-file-label::after {
		content: "{{ __('Browse') }}"
	}
</style>

@endsection

@section('scripts')

<script>
	$(document).ready(function() {



	});
</script>
@endsection