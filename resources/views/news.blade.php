@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('News') }}</h1>
</div>

<!-- Row -->
<div class="row">
	<div class="col-lg-8">

		@forelse ($articles as $article)
		<div class="card mb-4 py-4 px-5">

			<div class="row">
				<div class="col-md-4">

					@if ($article->getFirstMediaUrl('images', 'thumb_middle'))
					<img width="100" height="100" src="{{ $article->getFirstMediaUrl('images', 'thumb_middle') }}">
					@endif

				</div>
				<div class="col-md-8">
					<h4 class="mb-3">{{ $article->title }}</h4>
					<div>{{ $article->description }}</div>
					<div class="mt-3 d-flex flex-row align-items-center justify-content-end">
						<a class="btn btn-success" href="{{ route('new', $article->id) }}">{{ __('Read full text') }}</a>
					</div>
				</div>


			</div>
		</div>

		@empty
		@endforelse

	</div>
</div>
<!--Row-->

@endsection


@section('scripts')


<!-- Page level custom scripts -->
<script>
	$(document).ready(function() {



	});
</script>
@endsection