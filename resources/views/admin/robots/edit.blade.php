@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Edit robot') }}</h1>

	<a class="btn btn-light" href="{{ route('admin.robots.index') }}">
		{{ __('Back') }}
	</a>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">

			<div class="card-body">
				<form method="POST" action="{{ route('admin.robots.update', $robot->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PUT')

					<div class="form-group">
						<label for="title">{{ __('Title') }}</label>

						<input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $robot->title }}" autofocus>

						@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="description">{{ __('Short text') }}</label>

						<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ $robot->description }}</textarea>

						@error('description')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="version">{{ __('Version') }}</label>

						<input id="version" type="text" class="form-control @error('version') is-invalid @enderror" name="version" value="{{ $robot->version }}">

						@error('version')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>




					@if ($robot->getFirstMediaUrl('zips'))
					<div class="my-3">
						<a class="btn btn-light" target="_blank" href="{{ $robot->getFirstMediaUrl('zips') }}"><i class="far fa-file-archive mr-3"></i>{{ __('Download zip') }}</a>
					</div>
					@endif

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


					@if ($robot->getFirstMediaUrl('images', 'thumb_middle'))
					<div class="my-3">
						<img width="100" height="100" src="{{ $robot->getFirstMediaUrl('images', 'thumb_middle') }}">
					</div>
					@endif

					<div class="form-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="image" name="image">
							<label class="custom-file-label" for="image">{{ __('Cover') }}</label>
						</div>

						@error('image')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="lang">{{ __('Language') }}</label>

						<select class="form-control @error('lang') is-invalid @enderror" id="lang" name="lang">
							<option value="en" @if ($robot->lang == "en" ) selected @endif>{{ __('English') }}</option>
							<option value="ru" @if ($robot->lang == "ru" ) selected @endif>{{ __('Russian') }}</option>
						</select>

						@error('lang')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="1" name="public" id="public" {{ $robot->public ? 'checked' : '' }}>

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

<script>
	$(document).ready(function() {



	});
</script>
@endsection