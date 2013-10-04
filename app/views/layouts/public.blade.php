@include('header')

<div id="page-header">
    <a href="{{ route('home') }}"><i class="glyphicon glyphicon-home"></i></a>
    <a href="{{ route('archive') }}"><i class="glyphicon glyphicon-align-left"></i></a>
</div>

<div id="content" class="container">
    @yield('content')
</div>

@include('footer')