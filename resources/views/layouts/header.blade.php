		<header class="container flex flex-1 items-center justify-center mx-auto">
			<div class="flex items-center leading-none py-1">
				<a href="/admin/xdbshow" class="bg-gray-900 border border-gray-700 flex font-bold p-1 px-2 rounded text-2xl">
					<span class="text-red-500">x</span><span class="text-gray-200">DBShow</span>
				</a>
				<span class="font-normal mx-2 text-gray-700">{{ config('app.name', 'The Readonly DB') }}</span>
			</div>
			<div class="flex-1">
			</div>
			<div class="flex items-center rounded text-sm">
			@guest
				<a href="{{ Route::has('login') ? route('login') : '/login' }}" class="border p-1 px-2 rounded text-gray-700">{{ __('Login') }}</a>
			@else
				<a href="{{ Route::has('logout') ? route('logout') : '/logout' }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="border p-1 px-2 rounded text-gray-700">{{ __('Logout') }}</a>
			@endguest
			</div>
		</header>