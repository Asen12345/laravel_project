@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Edit parametr for robot setting') }}</h1>

	<a class="btn btn-light" href="{{ route('admin.robot-setting-parametrs.index', $parametr->setting) }}">
		{{ __('Back') }}
	</a>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">

			<div class="card-body">
				<form method="POST" action="{{ route('admin.robot-setting-parametrs.update', $parametr) }}">
					@csrf
					@method('PUT')

					<div class="form-group">
						<label for="index">{{ __('Index') }}</label>

						<input id="index" type="text" class="form-control @error('index') is-invalid @enderror" name="index" value="{{ $parametr->index }}" autofocus>

						@error('index')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="value">{{ __('Value') }}</label>

						<input id="value" type="text" class="form-control @error('value') is-invalid @enderror" name="value" value="{{ $parametr->value }}">

						@error('value')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
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

@endsection

@section('scripts')

<script>
	$(document).ready(function() {



	});
</script>
@endsection