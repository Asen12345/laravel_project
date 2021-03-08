@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Edit news') }}</h1>

	<a class="btn btn-light" href="{{ route('admin.news.index') }}">
		{{ __('Back') }}
	</a>
</div>

<!-- Row -->
<div class="row">
	<!-- DataTable -->
	<div class="col-lg-12">
		<div class="card mb-4">

			<div class="card-body">
				<form method="POST" action="{{ route('admin.news.update', $article->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PUT')

					<div class="form-group">
						<label for="title">{{ __('Title') }}</label>

						<input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $article->title }}" autofocus>

						@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="description">{{ __('Short text') }}</label>

						<textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ $article->description }}</textarea>

						@error('description')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="text">{{ __('Text') }}</label>

						<textarea class="form-control editor @error('text') is-invalid @enderror" id="text" name="text" rows="3">{{ $article->text }}</textarea>

						@error('text')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					@if ($article->getFirstMediaUrl('images', 'thumb_middle'))
					<div class="my-3">
						<img width="100" height="100" src="{{ $article->getFirstMediaUrl('images', 'thumb_middle') }}">
					</div>
					@endif

					<div class="form-group">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="image" name="image">
							<label class="custom-file-label" for="image">{{ __('Image') }}</label>
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
							<option value="en" @if ($article->lang == "en" ) selected @endif>{{ __('English') }}</option>
							<option value="ru" @if ($article->lang == "ru" ) selected @endif>{{ __('Russian') }}</option>
						</select>

						@error('lang')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>

					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="1" name="public" id="public" {{ $article->public ? 'checked' : '' }}>

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