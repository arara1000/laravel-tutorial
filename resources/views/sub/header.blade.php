{{-- 変数 --}}
@php
  $links = [['Home', route('root')], ['Help', route('help')], ['Log in', '#']];
@endphp

<header class="bg-gray-900 py-5 px-15">
  <div class="flex justify-between">
    <div class="text-white text-2xl font-bold"><a href={{ route('root') }}>SAMPLE APP</a></div>
    <nav>
      <ul class="flex gap-5">
        @foreach ($links as $link)
          <li><a href="{{ $link[1] }}" class="text-gray-300">{{ $link[0] }}</a></li>
        @endforeach
      </ul>
    </nav>
  </div>
</header>
