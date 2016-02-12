<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title') EasyAffiliate @show</title>
    @section('meta_keywords')
        <meta name="keywords" content="your, awesome, keywords, here"/>
    @show @section('meta_author')
        <meta name="author" content="Mikael Laine"/>
    @show @section('meta_description')
        <meta name="description"
              content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei."/>
    @show

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">
    <!-- Needs images, font... therefore can not be part of main.css -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bower_components/weather-icons/css/weather-icons.min.css">
    <!-- end Needs images -->

    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/style.css">
    <script type="text/javascript" src="/assets/js/respond.min.js"></script>

    @yield('styles')

    <link rel="shortcut icon" href="{{{ asset('assets/site/ico/favicon.ico') }}}">
</head>
<body data-ng-app="app" id="app" class="app nav-collapsed-min" data-custom-page data-off-canvas-nav data-ng-controller="AppCtrl" data-ng-class=" {'layout-boxed': admin.layout === 'boxed' } ">
    <div class="main-container">
        @yield('content')
    </div>


<script src="/scripts/vendor.js"></script>
<script src="/scripts/ui.js"></script>
<script src="/scripts/app.js"></script>

@yield('scripts')

</body>
</html>
