@extends('layouts.panel')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ __('News') }} – {{ $article->title }}</h1>
</div>

<!-- Row -->
<div class="row">
	<div class="col-lg-8">

		<div class="card mb-4 py-4 px-5">

			<div class="row">
				<div class="col-md-12">
					<div style="color: rgba(0,0,0,0.3);" class="mb-3">{{ __('Published') }}: {{ date('d.m.Y H:i', strtotime($article->created_at)) }}</div>

					@if ($article->getFirstMediaUrl('images', 'thumb_big'))
					<img style="float: left;" class="mr-4 mb-4" width="200" height="200" src="{{ $article->getFirstMediaUrl('images', 'thumb_big') }}">
					@endif

					<div>{!! $article->text !!}</div>
				</div>


			</div>
		</div>


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