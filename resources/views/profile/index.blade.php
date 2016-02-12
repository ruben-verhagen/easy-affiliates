@extends('app')
@section('title') Affiliates @parent @stop
@section('content')

<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Your Profile</strong></div>
            <div class="panel-body">
                <!-- main content here -->

                <form action="#" class="form-horizontal no-submit" id="form-changepassword" method="post">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <input type="hidden" name="cmd" value="password" />
                        <input type="hidden" name="email" value="{{ $user->email }}" >
                        <!-- Form Name -->
                        <legend>Change Password</legend>

                        <!-- Password input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="old_password">
                                Old Password
                            </label>
                            <div class="controls col-lg-8">
                                <input name="old_password" type="password" placeholder="" class="input-xlarge form-control" >
                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="new_password">
                                    New Password
                            </label>
                            <div class="controls col-lg-8">
                                <input name="password" type="password" placeholder="" class="input-xlarge form-control" >
                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="new_password_confirm">
                                Confirm New Password
                            </label>
                            <div class="controls col-lg-8">
                                <input name="password_confirmation" type="password" placeholder=""  class="input-xlarge form-control">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="change_password"></label>
                            <div class="controls col-lg-8">
                                <button type="submit" id="change_password" class="btn btn-primary">
                                    Update
                                </button>
                                @if ($pwd_success = Session::get('pwd_success'))
                                <h4>{{ $pwd_success }}</h4>
                                @endif
                                @if ($pwd_error = Session::get('pwd_error'))
                                <h4>{{ $pwd_error }}</h4>
                                @endif
                            </div>
                        </div>

                    </fieldset>
                </form>

                <form action="#" class="form-horizontal no-submit" id="app-details" method="post">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <input type="hidden" name="cmd" value="general" />
                        <!-- Form Name -->
                        <legend>App status</legend>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="app_name">
                                App Name
                            </label>
                            <div class="controls col-lg-8">
                                <input name="app_name" type="text" value="{{ $user_is->app_name }}" class="input-xlarge form-control" readonly>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="update_details"></label>
                            <div class="controls col-lg-8">
                                <a href="{{ URL::to('profile/app') }}" type="submit" id="update_details" class="btn btn-primary">
                                    Connect
                                </a>

                            </div>
                        </div>

                    </fieldset>
                </form>

                <form action="#" class="form-horizontal no-submit" id="form-details" method="post">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <input type="hidden" name="cmd" value="general" />
                        <!-- Form Name -->
                        <legend>Your details</legend>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="first_name">
                                First Name
                            </label>
                            <div class="controls col-lg-8">
                                <input name="first_name" type="text" value="{{ $user_is->first_name }}" class="input-xlarge form-control">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="last_name">
                                Last Name
                            </label>
                            <div class="controls col-lg-8">
                                <input name="last_name" type="text" value="{{ $user_is->last_name }}" class="input-xlarge form-control">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="address">
                                Address
                            </label>
                            <div class="controls col-lg-8">
                                <input name="address" type="text"  class="input-xlarge form-control">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="phone">
                               Phone
                            </label>
                            <div class="controls col-lg-8">
                                <input name="phone" type="text" class="input-xlarge form-control">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="update_details"></label>
                            <div class="controls col-lg-8">
                                <button type="submit" id="update_details" class="btn btn-primary">
                                    Update
                                </button>
                                @if ($gen_success = Session::get('gen_success'))
                                <h4>{{ $gen_success }}</h4>
                                @endif
                                @if ($gen_error = Session::get('gen_error'))
                                <h4>{{ $gen_error }}</h4>
                                @endif
                            </div>
                        </div>

                    </fieldset>
                </form>

                <form action="#" class="form-horizontal no-submit" id="form-payments" method="post">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <input type="hidden" name="cmd" value="payment" />
                        <!-- Form Name -->
                        <legend>Payment Details</legend>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="phone">
                                PAYPAL_APP_ID
                            </label>
                            <div class="controls col-lg-8">
                                <input name="paypal_app_id" type="text" value="{{ $user_is->paypal_app_id }}" class="input-xlarge form-control" required>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="first_name">
                                PAYPAL_API_PASSWORD
                            </label>
                            <div class="controls col-lg-8">
                                <input name="paypal_api_username" type="text" value="{{ $user_is->paypal_api_username }}" class="input-xlarge form-control" required>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="last_name">
                                PAYPAL_API_PASSWORD
                            </label>
                            <div class="controls col-lg-8">
                                <input name="paypal_api_password" type="text" value="{{ $user_is->paypal_api_password }}" class="input-xlarge form-control" required>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="address">
                                PAYPAL_API_SIGNATURE
                            </label>
                            <div class="controls col-lg-8">
                                <input name="paypal_api_signature" type="text" value="{{ $user_is->paypal_api_signature }}" class="input-xlarge form-control" required>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="phone">
                                PAYPAL_BUSINESS_ACCOUNT
                            </label>
                            <div class="controls col-lg-8">
                                <input name="paypal_business_account" type="text" value="{{ $user_is->paypal_business_account }}" class="input-xlarge form-control" required>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="update_paymentdetails"></label>
                            <div class="controls col-lg-8">
                                <button type="submit" id="update_paymentdetails" class="btn btn-primary">
                                    Update
                                </button>
                                @if ($pay_success = Session::get('pay_success'))
                                <h4>{{ $pay_success }}</h4>
                                @endif
                                @if ($pay_error = Session::get('pay_error'))
                                <h4>{{ $pay_error }}</h4>
                                @endif
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
    @parent

@endsection
@stop