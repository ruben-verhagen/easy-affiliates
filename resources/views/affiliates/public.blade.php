@extends('public')
@section('title') @parent @stop
@section('content')

<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Affiliate Overview ({{$affiliate['AffName']}})</strong></div>
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
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Get/Upload W9</strong></div>
            <div class="panel-body">
                <form action="#" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Current W9 file</label>
                        <div class="col-sm-10">
                            @if ($affiliate_row['w9_file'])
                                <a href="/w9files/{{ $affiliate_row->id }}" class="btn"> <strong>{{ $affiliate_row['w9_file_original_name'] }}</strong> </a>
                            @else
                                No file yet
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Choose a file</label>
                        <div class="col-sm-10">
                            <input type="file" title="Choose File" name="w9file" data-ui-file-upload accept=".pdf">
                            <div class="space"></div>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Upload</button>
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
        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Commissions</strong></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Date</th>
                        <th>Contact</th>
                        <th>Item</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($commissions as $item)
                        <tr>
                            <td>#{{ $item['InvoiceId'] }}</td>
                            <td>{{ date("j/n/Y", strtotime($item['DateEarned'])) }}</td>
                            <td>{{ $item['ContactFirstName'] . ' ' . $item['ContactLastName'] }}</td>
                            <td>{{ $item['ProductName'] }}</td>
                            <td>${{ $item['AmtEarned'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Payments </strong></div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payouts as $item)
                        <tr>
                            <td>{{ date("j/n/Y", strtotime($item['PayDate'])) }}</td>
                            <td>{{ $item['PayNote'] }}</td>
                            <td>${{ number_format($item['PayAmt'], 2) }}</td>
                        </tr>
                    @endforeach
                    @foreach ($payments as $item)
                        <tr>
                            <td>{{ date("j/n/Y", strtotime($item['created_at'])) }}</td>
                            <td>Paypal</td>
                            <td>${{ number_format($item['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
    @parent
@endsection
@stop