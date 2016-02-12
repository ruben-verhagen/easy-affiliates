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
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Welcome</strong></div>
            <div class="panel-body">
                <p>Welcome to your EasyAffiliate  Manager.</p>

                <p>Find your monthly or daily metrics for Affiliate Use below or navigate to find individual Affiliate Ledger reports on the menu to the left. Once your Payment integration is made, you can easily add 1 Click Payments.</p>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Sales Report</strong></div>
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
                    <button type="submit" class="btn btn-primary btn-sm" >Reload Stats</button>
                </form>
            </div>
            <div class="panel-body bg-grey">
                <div class="row">
                    <div class="col-md-12">
                        <!-- stats -->
                        <div class="row ">
                            <div class="col-xsm-4 ">
                                <div class="panel mini-box " >
                                    <span class="box-icon rounded bg-success">
                                        <i class="fa fa-shopping-cart"></i>
                                    </span>
                                    <div class="box-info">
                                        <p class="size-h2">$<?=number_format($total_sales, 2)?></p>
                                        <p class="text-muted"><span data-i18n="Total Sales"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xsm-4">
                                <div class="panel mini-box">
                                    <span class="box-icon rounded bg-info">
                                        <i class="fa fa-location-arrow"></i>
                                    </span>
                                    <div class="box-info">
                                        <p class="size-h2">$<?=number_format($total_commission, 2)?></p>
                                        <p class="text-muted"><span data-i18n="Total Commission"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xsm-4">
                                <div class="panel mini-box">
                                    <span class="box-icon rounded bg-danger">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <div class="box-info">
                                        <p class="size-h2"><?=$total_owed < 0 ? '-' : ''?>$<?=number_format(abs($total_owed), 2)?></p>
                                        <p class="text-muted"><span data-i18n="Total Owed"></span></p>
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
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Total # of Affiliates</strong></div>
            <div class="panel-body">
                <h2>Your Total Number of Affiliates: <?=$affiliates_count?> </h2>
                <a href="{{ URL::to('affiliates/add') }}" class="btn btn-primary text-center">Add New Affiliate</a>&nbsp;
                <a href="{{ URL::to('affiliates') }}" class="btn btn-primary text-center">View All Affiliates</a>&nbsp;
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Top Monthly Affiliates</strong></div>
            <div class="panel-body table-responsive">
                <table class="table" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Commission</th>
                        <th>Payout</th>
                        <th>Balance</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;?>
                    @foreach ($all_affiliates as $affiliate)
                    <?php $affiliate_row = $affiliate['row'];?>
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $affiliate_row->first_name }}</td>
                        <td>{{ $affiliate_row->last_name }}</td>
                        <td>{{ number_format($affiliate['commission'], 2) }}</td>
                        <td>{{ number_format($affiliate['payout'], 2)  }}</td>
                        <td>{{ number_format($affiliate['balance'], 2) }}</td>
                        <td>
                            <a href="{{ URL::to('affiliates/' . $affiliate['Id']) }}" class="btn btn-primary">View Ledger</a>&nbsp;
                            @if ($affiliate_row)
                            @if ($affiliate_row['w9_file'])
                            <a href="{{ URL::to('affiliates/' . $affiliate['Id'] . '/pay') }}" class="btn btn-info ">Pay Now</a>&nbsp;
                            <a href="/w9files/{{ $affiliate_row->id }}" class="btn btn-success"> Download W9 </a>
                            @else
                            <a href="{{ URL::to('affiliates/' . $affiliate['Id'] . '/pay') }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to pay without W9?')"> Pay Now</a>&nbsp;
                            <a href="{{ URL::to('affiliates/' . $affiliate['Id'] . '/notify') }}" class="btn btn-warning" onclick="return confirm('Are you sure you want to remind your affiliate of their w9?')"> Get W9 </a>
                            @endif
                            @endif
                        </td>
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
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0, 5 ] }
            ]
        });


        $('.input-daterange').datepicker({
            todayBtn: "linked"
        });
    } );
</script>
@endsection
@stop
