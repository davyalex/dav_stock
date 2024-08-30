<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{config('app.name')}} - @yield('title') </title>
    <meta name="description" content="">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    @include('site.layouts.vendor-css')

<body>
   
    @include('site.layouts.header') <!-- header start -->

    @if (!Request::routeIs('accueil'))
    @include('site.components.breadcrumb')
    @endif

    @yield('content') <!-- content start -->

    @include('site.layouts.footer') <!-- footer start -->
</body>

</html>
