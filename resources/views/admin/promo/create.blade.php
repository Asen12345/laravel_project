@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Create promo') }}</h1>

	<a class="btn btn-light" href="{{ route('admin.promo.index') }}">
		{{ __('Back') }}
	</a>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">

			<div class="card-body">
				<form method="POST" action="{{ route('admin.promo.store') }}" enctype="multipart/form-data">
					@csrf

					<div class="form-group">
						<label for="title">{{ __('Title') }}</label>

						<input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autofocus>

						@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>


					<div class="form-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="zip" name="zip">
							<label class="custom-file-label" for="zip">{{ __('Zip file') }}</label>
						</div>

						@error('zip')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>


					<div class="form-group">
						<label for="lang">{{ __('Language') }}</label>

						<select class="form-control @error('lang') is-invalid @enderror" id="lang" name="lang">
							<option value="en">{{ __('English') }}</option>
							<option value="ru" selected>{{ __('Russian') }}</option>
						</select>

						@error('lang')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>


					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="1" name="public" id="public" {{ old('public') ? 'checked' : '' }}>

							<label class="form-check-label" for="public">
								{{ __('Public') }}
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
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>
	$(document).ready(function() {

		tinymce.init({
			selector: 'textarea.editor',
			// theme: "simple",
			height: 300,
			// language: "ru",
		});

	});
</script>
@endsection