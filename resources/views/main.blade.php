<!DOCTYPE html>
<html lang="en">
<head>
@include('partials._head')
</head>
<body>
@include('partials._nav')
<!--Default bootstrap navbar -->

<div class="container">

    @include('partials._messages')


    @yield('content') <!-- Blade content. Seems what't be different in pages. Blade layouts-->

@include("partials._footer")

</div>

@include('partials._js')

@yield('scripts')
</body>
</html>