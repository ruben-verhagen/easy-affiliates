<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EasyAffiliate</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">
    <!-- Needs images, font... therefore can not be part of main.css -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bower_components/weather-icons/css/weather-icons.min.css">
    <!-- end Needs images -->

    <script src="/old/scripts//jquery.js"></script>
    <script src="/old/scripts//bootstrap.js"></script>

    <link rel="stylesheet" href="/styles/main.css">

</head>
<body style="background: url(/assets/images/bg-pattern/login_page_bg.jpg) repeat #fff;">
<div class="page-signin">

    <div class="signin-header">
        <section class="logo text-center">
            <a href="#/"><img src="/assets/images/logo2-small.png" class=""></a>
        </section>
    </div>

    <div class="signin-body">
        <div class="container">
            <div class="form-container">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                @include('errors.list')

                <form class="form-horizontal" role="form" method="POST" action="{!! URL::to('/password/email') !!}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Send Password Reset Link
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
