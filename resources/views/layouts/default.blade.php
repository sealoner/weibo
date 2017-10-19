<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App') - 基于Laravel5.5的仿微博App</title>
    <link rel="stylesheet" href="/css/app.css">
  </head>
  <body>
@include('layouts/_header')

    <div class="container">
      @include('shared._messages')
      @yield('content')
      @include('layouts/_footer')
    </div>
  </body>
</html>

