{{-- 変数 --}}
@php
  $links = [['About', route('about')], ['Contact', route('contact')], ['News', 'https://news.railstutorial.org/']];
@endphp

<footer class="flex justify-between border-t border-gray-300 py-4">
  <small>
    The <a href="https://railstutorial.jp/">Ruby on Rails Tutorial</a>
    by <a href="https://www.michaelhartl.com/">Michael Hartl</a>
  </small>
  <nav>
    <ul class="flex gap-5">
      @foreach ($links as $link)
        <li><a href="{{ $link[1] }}">{{ $link[0] }}</a></li>
      @endforeach
    </ul>
  </nav>
</footer>
