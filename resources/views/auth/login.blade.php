<!doctype html>
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EasyAffiliate</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="/favicon.png">
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
                @include('errors.list')
                <form class="form-horizontal" role="form" method="POST" action="{!! URL::to('/auth/login') !!}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <fieldset>
                        <div class="form-group">
                            <span class="glyphicon glyphicon-envelope"></span>
                            <input type="text" id="login-username" name="email" value="{{ old('email') }}" placeholder="Username" class="input-lg form-control input-round text-center">
                        </div>
                        <div class="form-group">
                            <span class="glyphicon glyphicon-lock"></span>
                            <input type="password" id="login-password" name="password" placeholder="Password" class="input-lg form-control input-round text-center">
                        </div>
                        <div class="form-group">
                            <button id="btn-login" class="btn btn-primary btn-lg btn-round btn-block text-center">Login</button>
                        </div>
                    </fieldset>
                    <section>
                        <p class="text-center"><a href="{!! URL::to('/password/email') !!}">Forgot your password?</a></p>
                        <!--<p class="text-center text-muted text-small">Don't have an account yet? <a href="{!! URL::to('/auth/register') !!}" >Sign up</a></p>-->
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
