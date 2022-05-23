@extends('xDBShow::layouts.app')

@section('title', 'Index')

@section('header')
  @include('xDBShow::layouts.header')
@endsection

@section('main')
  <main class="flex flex-1 items-center p-2">
    <div class="container flex-1 mx-auto">
      <h1 class="text-4xl uppercase">{{ $databaseName }}'s Tables</h1>
      <hr class="bg-gray-200 my-4">
      <div class="flex flex-col space-y-1">
        @foreach ($data as $table)
        <div class="bg-gray-200 border00 flex flex-1 p-2 px-4 rounded text-gray-7">
          <div class="flex-1">
            <a href="/admin/xdbshow/{{ $table->name }}" class="text-blue-700">{{ $table->name }}</a>
            <span class="text-gray-400">({{ $table->type }})</span>
          </div>
          <span>{{ $table->count }} records</span>
        </div>
        @endforeach
      </div>
  </main>
@endsection

@section('footer')
  @include('xDBShow::layouts.footer')
@endsection