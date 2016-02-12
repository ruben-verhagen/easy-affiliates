@extends('app')
@section('title') @parent @stop
@section('content')

<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Easily Create a New Affiliate Below</strong></div>
            <div class="panel-body">
                @if ($error = Session::get('error'))
                    {{ $error }}
                @endif
                <form action="{{ URL::to('affiliates/add') }}" method="post" role="form">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first">First Name *</label>
                                <input type="text" class="form-control input-lg" id="first_name" name="first_name" placeholder="First Name" tabindex="1" required>
                            </div>

                            <div class="form-group">
                                <label for="last">Last Name *</label>
                                <input type="text" class="form-control input-lg" id="last_name" name="last_name" placeholder="Last Name" tabindex="2" required >
                            </div>

                            <div class="form-group">
                                <label for="first">PayPal Email *</label>
                                <input type="email" class="form-control input-lg" id="paypal" name="paypal" placeholder="Paypal Email" tabindex="3" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password *</label>
                                <input type="password" class="form-control input-lg" id="password" name="password" placeholder="Password" tabindex="4" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirm">Confirm Password *</label>
                                <input type="password" class="form-control input-lg" id="password_confirm" name="password_confirm" placeholder="Confirm Password" tabindex="5" required>
                            </div>

                            <div class="form-group">
                                <label for="program">Affiliate Program *</label>
                                <select name="program" id="program" class="form-control input-lg" tabindex="6" required>
                                    <option value="">Choose Affiliate Program</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program['Id'] }}">{{ $program['Name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="checkbox">
                                <label class="input-lg" data-toggle="tooltip" data-placement="right" title="Click this checkbox if you have not received a W9 from your Affiliate, yet. EasyAffiliate will automatically email them with a generated W9 and uploader to insert into their own Affiliate Dash.">
                                    <input type="checkbox" tabindex="7" name="w9" id="w9" > Confirm W9 Upload?
                                </label>
                            </div>

                            <div class="checkbox">
                                <label class="input-lg" >
                                    <input type="checkbox" tabindex="8" name="confirmation" id="confirmation"> Send Confirmation Email?
                                </label>
                            </div>

                            <div class="checkbox">
                                <label class="input-lg" >
                                    <input type="checkbox" tabindex="9" name="monthlystats" id="monthlystats"> Schedule Monthly Stats?
                                </label>
                            </div>

                            <button type="submit" name="submit" id="submit" class="btn btn-primary" >Create Affiliate</button>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="email">Email * </label>
                                <input type="email" class="form-control input-lg" id="email" name="email" placeholder="Email Address" tabindex="12" required  >
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control input-lg" id="phone" name="phone" placeholder="Phone Number" tabindex="13">
                            </div>

                            <div class="form-group">
                                <label for="parent">Parent Affiliate</label>
                                <select class="form-control input-lg" id="parent" name="parent" tabindex="14">
                                    <option value=""></option>
                                    @foreach ($affiliates as $affiliate)
                                        <option value="{{ $affiliate['Id'] }}">{{ $affiliate['AffName'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="aff_code">Affiliate Code</label>
                                <input type="text" class="form-control input-lg" id="aff_code" name="aff_code" placeholder = "Unique Affiliate Code" tabindex="15">
                            </div>

                            <div class="form-group">
                                <label for="aff_code">Choose a tag </label>
                                <select name="tag_id" id="tag_id" class="form-control input-lg " >
                                    <option value=""></option>
                                    @foreach ($tags_grouped as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phone">Or Create New Tag</label>
                                <input type="text" class="form-control input-lg" id="tag_name" name="tag_name" placeholder="Tag Name" tabindex="16">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
    @parent
    <script src="/assets/js/bootstrap-tooltip.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip()
        } );
    </script>

@endsection
@stop
