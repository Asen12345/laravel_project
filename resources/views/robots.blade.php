@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('Robots') }}</h1>
</div>

<!-- Row -->
<div class="row">
	<div class="col-lg-8">

		@forelse ($robots as $robot)
		<div class="card mb-4 py-4 px-5">

			<div class="row">
				<div class="col-md-4">
					@if ($robot->getFirstMediaUrl('images', 'thumb_big'))
					<img style="float: left;" class="mr-4 mb-4" width="200" height="200" src="{{ $robot->getFirstMediaUrl('images', 'thumb_big') }}">
					@endif
				</div>
				<div class="col-md-8">
					<h4 class="mb-3">{{ $robot->title }}</h4>
					<div>{{ $robot->description }}</div>
					<div class="mt-3 d-flex flex-row align-items-center justify-content-between">
						<span>{{ __('Version') }}: {{ $robot->version }}</span>

						@if ($robot->getFirstMediaUrl('zips'))
						<div class="my-3">
							<a class="btn btn-success" target="_blank" href="{{ $robot->getFirstMediaUrl('zips') }}">{{ __('Download') }}</a>
						</div>
						@endif
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