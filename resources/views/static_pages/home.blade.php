@section('title', '')
<x-layout>
  <div class="bg-gray-100 text-center mx-auto p-10">
    <h1 class="text-4xl font-bold mb-3">Welcome to the Sample App</h1>
    <h2 class="mb-4 text-sm">
      This is the home page for the
      <a href="https://railstutorial.jp/" class="text-link">Ruby on Rails Tutorial</a>
      sample application.
    </h2>
    <a href={{ route('signup') }} class="btn">Sign up now!</a>
  </div>

  <a href="https://rubyonrails.org/" class="block w-[30%]"><img src="/images/laravel.svg" alt="Laravel logo" /></a>
</x-layout>
