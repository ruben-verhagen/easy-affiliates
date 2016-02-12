@extends('app')
@section('title') Affiliates @parent @stop
@section('content')

<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Your Profile</strong></div>
            <div class="panel-body">
                <!-- main content here -->
                <h4>
                    @if ($connected)
                    Your app is now connected.
                    @else
                    Your app is NOT connected, please try again here.
                    @endif
                </h4>
                <form action="#" class="form-horizontal no-submit" id="form-details" method="post">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <input type="hidden" name="cmd" value="app" />
                        <!-- Form Name -->
                        <legend>Infusionsoft Integration</legend>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="app_name">
                                App Name
                            </label>
                            <div class="controls col-lg-8">
                                <input name="app_name" type="text" value="{{ $user_is->app_name }}" class="input-xlarge form-control">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="app_apikey">
                                App API Key
                            </label>
                            <div class="controls col-lg-8">
                                <input name="app_apikey" type="text" value="{{ $user_is->app_apikey }}" class="input-xlarge form-control">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="control-group form-group">
                            <label class="control-label col-lg-4" for="update_details"></label>
                            <div class="controls col-lg-8">
                                <button type="submit" id="update_details" class="btn btn-primary">
                                    Update
                                </button>
                                @if ($app_success = Session::get('app_success'))
                                <h4>{{ $app_success }}</h4>
                                @endif
                                @if ($app_error = Session::get('app_error'))
                                <h4>{{ $app_error }}</h4>
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