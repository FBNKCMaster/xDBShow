<!DOCTYPE html>
<html class="h-full min-h-screen" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>{{ config('app.name', 'xDBShow') }} @yield('title')</title>
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@xDBShow">
    <meta name="twitter:title" content="xDBShow">
    <meta name="twitter:description" content="The Readonly Package for your DB">
    <meta name="twitter:image" content="https://github.com/FBNKCMaster/xDBShow.png">
    <meta name="twitter:creator" content="@FBNKCMaster">
    <meta property="og:url" content="https://github.com/FBNKCMaster/xDBShow" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="xDBShow" />
    <meta property="og:description" content="The Readonly Package for your DB" />
    <meta property="og:image" content="https://github.com/FBNKCMaster/xDBShow.png" />
    @stack('scripts')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="{{ asset('fbnkcmaster/xdbshow/css/app.css') }}" rel="stylesheet">
    <!-- <style>svg { pointer-events: none; }</style> -->
  </head>
  <body class="flex flex-col leading-normal min-h-screen text-gray-900">
    <div id="app" class="flex-1">
      @yield('header')
      @yield('nav')
      @yield('main')
    </div>
    @yield('footer')
    <form id="logout-form" action="/logout" method="POST" class="hidden">{{ csrf_field() }}</form>
  </body>
</html>
