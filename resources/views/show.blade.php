@extends('xDBShow::layouts.app')

@section('title', 'Index')

@section('header')
  @include('xDBShow::layouts.header')
@endsection

@section('main')
	<main class="flex flex-1 items-center p-2">
    <div class="container flex-1 mx-auto">
      <h1 class="text-4xl uppercase">{{ $title }}</h1>
      <hr class="bg-gray-200 my-4">
			<div class="overflow-x-auto">
				@if (is_object($records) && is_object($records[0]))
				<table class="text-xs w-full">
					<thead>
						<tr class="bg-gray-200 border border-gray-200">
							@foreach($records[0] as $column => $v)
							<th class="border-l border-r px-1" style="border-color:#fff;">{{ $column }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($records as $row)
						<tr class="bg-gray-100/50 border border-gray-200">
							@foreach($row as $column => $v)
							<td class="border-l border-r px-1 {{ gettype($v) == 'integer' || strpos($column, '_at') !== false ? ' text-center' : '' }}" style="border-color:#fff;">{{ is_array($v) ? json_encode($v) : $v }}</td>
							@endforeach
						</tr>
						@endforeach
					</tbody>
				</table>
				@else
				<span class="text-sm">There are no records to display.</span>
				@endif
			</div>
			<div class="bg-gray-200 h-1 mb-2"></div>
			{{ $records->onEachSide(1)->links('xDBShow::components.pagination') }}
		</div>
  </main>
@endsection

@section('footer')
  @include('xDBShow::layouts.footer')
@endsection