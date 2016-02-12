@extends('app')
@section('title') @parent @stop
@section('content')

<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Affiliate Overview ({{$affiliate_row['first_name']}} {{$affiliate_row['last_name']}})</strong></div>
            <div class="panel-body bg-grey">
                <div class="row ">
                    <div class="col-md-12">
                        <!-- stats -->
                        <div class="row">
                            <div class="col-xsm-3">
                                <div class="panel mini-box">
                                    <span class="box-icon rounded bg-success">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <div class="box-info">
                                        <p class="size-h2">${{ number_format($total_record['AmountEarned'], 2) }}</p>
                                        <p class="text-muted"><span data-i18n="Amount Earned"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xsm-3">
                                <div class="panel mini-box">
                                    <span class="box-icon rounded bg-warning">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <div class="box-info">
                                        <p class="size-h2">${{ number_format($total_record['Clawbacks'], 2) }}</p>
                                        <p class="text-muted"><span data-i18n="Clawbacks"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xsm-3">
                                <div class="panel mini-box">
                                    <span class="box-icon rounded bg-danger">
                                        <i class="fa fa-shopping-cart"></i>
                                    </span>
                                    <div class="box-info">
                                        <p class="size-h2">${{number_format($total_record['Payments'] + $payout, 2) }}</p>
                                        <p class="text-muted"><span data-i18n="Amount Paid"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xsm-3 ">
                                <div class="panel mini-box">
                                    <span class="box-icon rounded bg-info">
                                        <i class="fa fa-location-arrow"></i>
                                    </span>
                                    <div class="box-info">
                                        <p class="size-h2">{{ $amount < 0 ? '-' : '' }} {{number_format(abs($amount), 2) }}</p>
                                        <p class="text-muted"><span data-i18n="Pending Balance"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end stats -->
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Pay this affiliate </strong> </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="{{ URL::to('affiliates/' . $affiliate_row['aff_id'] . '/pay') }}">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                    <div class="form-group hidden">
                        <div class="col-sm-10">
                            <input type="hidden" name="email" value="{{ $affiliate_row['paypal_email'] }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2">Balance</label>
                        <div class="col-sm-3">
                            {{ $amount < 0 ? '-' : '' }}${{ abs($amount) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2">Amount</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-round"  name="amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button type="submit" class="btn btn-w-md btn-gap-v btn-primary">Pay</button>
                            <a href="{{ URL::to('affiliates/' . $affiliate_row['aff_id']) }}" class="btn btn-w-md btn-gap-v btn-primary">Cancel</a>
                            @if ($success = Session::get('success'))
                            <h4>{{ $success }}</h4>
                            @endif
                            @if ($error = Session::get('error'))
                            <h4>{{ $error }}</h4>
                            @endif
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
    <script type="text/javascript" src="/assets/js/zero_clipboard/ZeroClipboard.min.js"></script>
    <script >
        $(document).ready(function() {
            // clipboard
            var client = new ZeroClipboard(document.getElementsByClassName("copy-button") );
            client.on( "ready", function( readyEvent ) {
                client.on( "aftercopy", function( event ) {
                    alert ('Track link is copied to clipboard.');
                });
            });
        });
    </script>
@endsection
@stop