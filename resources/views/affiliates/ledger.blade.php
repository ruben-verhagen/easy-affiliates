@extends('app')
@section('title') @parent @stop
@section('styles')
<link rel="stylesheet" href="/assets/css/jquery.dataTables.css">
<link rel="stylesheet" href="/assets/css/bootstrap-datepicker3.css">
@endsection
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
                                @if ($affiliate_row)
                                    @if ($affiliate_row['w9_file'])
                                        <a href="{{ URL::to('affiliates/' . $affiliate_row['aff_id'] . '/pay') }}" class="btn btn-info ">Pay Now</a>&nbsp;
                                        <a href="/files/{{$affiliate_row['w9_file'] }}" target="_blank" class="btn btn-success"> Download W9 </a>
                                    @else
                                        <a href="{{ URL::to('affiliates/' . $affiliate_row['aff_id'] . '/pay') }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to pay without W9?')"> Pay Now</a>&nbsp;
                                        <a href="{{ URL::to('affiliates/' . $affiliate_row['aff_id'] . '/notify') }}" class="btn btn-warning" onclick="return confirm('Are you sure you want to remind your affiliate of their w9?')"> Get W9 </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!-- end stats -->
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $affiliate_row->first_name }}'s Affiliate Dashboard</strong></div>
            <div class="panel-body">
                <label>{{ $aff_link }}</label>
                <input type="hidden" class="form-control" value="{{ $aff_link }}" id="aff-link" >
                <a class="btn btn-sm btn-primary copy-button" href="#" data-clipboard-target="aff-link"> Copy Link to Clipboard</a>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="#" class="form-inline" role="form" method="post">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <label>Date Range</label>
                    <div class="form-group">
                        <div class="input-daterange">
                            <input type="text" class="input-small form-control" name="start_date" value="{{ $start_date }}" />
                            <span class="add-on">-</span>
                            <input type="text" class="input-small form-control" name="finish_date" value="{{ $finish_date }}" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" >Reload Tables</button>
                </form>
            </div>
        </div>


        <div class="panel panel-default no-search">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Commissions & Sold Products</strong></div>
            <div class="panel-body table-responsive">
                <div class="row ">
                    <div class="col-md-8">
                        <table class="table" class="display " cellspacing="0" width="100%">
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
                    <div class="col-md-4">
                        <table class="table" class="display " cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                            @if ($product['Qty'] > 0)
                            <tr>
                                <td>{{ $product['ProductName'] }}</td>
                                <td>{{ $product['Qty'] }}</td>
                            </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Payments </strong></div>
            <div class="panel-body table-responsive">
                <table class="table" class="display" cellspacing="0" width="100%">
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

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><span class="glyphicon glyphicon-tags"></span> Tags</strong></div>
                    <div class="panel-body table-responsive">

                        <table class="table" class="display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>ContactGroup</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tags_assigned as $tag)
                            <tr>
                                <td>{{ $tag['ContactGroup'] != null ? $tag['ContactGroup'] : '-'  }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong><span class="glyphicon glyphicon-tag"></span> Apply Tag</strong></div>
                    <div class="panel-body table-responsive">
                        <form class="form-horizontal" method="post" action="{{ URL::to('affiliates/' . $affiliate_row['aff_id'] . '/addtag') }}">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-group">
                                <label for="tag_id" class="col-sm-4">Choose a Existing Tag </label>
                                <div class="col-sm-8">
                                    <select name="tag_id" id="tag_id" class="form-control " >
                                        <option value=""></option>
                                        @foreach ($tags_grouped as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tag_name" class="col-sm-4">Or Create New Tag </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-round"  name="tag_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit" class="btn btn-w-md btn-gap-v btn-primary">Apply Now</button>
                                    @if ($tag_message = Session::get('tag_message'))
                                    <h4>{{ $tag_message }}</h4>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="/assets/js/zero_clipboard/ZeroClipboard.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/bootstrap-datepicker.js"></script>

    <script >
        $(document).ready(function() {
            // clipboard
            var client = new ZeroClipboard(document.getElementsByClassName("copy-button") );
            client.on( "ready", function( readyEvent ) {
                client.on( "aftercopy", function( event ) {
                    alert ('Affiliate link is copied to clipboard.');
                });
            });

            $('.table').DataTable({
                
            });

            $('.input-daterange').datepicker({
                todayBtn: "linked"
            });

        });
    </script>
@endsection
@stop