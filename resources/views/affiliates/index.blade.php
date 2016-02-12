@extends('app')
@section('title') @parent @stop
@section('styles')
<link rel="stylesheet" href="/assets/css/jquery.dataTables.css" xmlns="http://www.w3.org/1999/html">
<link rel="stylesheet" href="/assets/css/bootstrap-datepicker3.css">

@endsection
@section('content')

<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Total # of Affiliates</strong></div>
            <div class="panel-body">
                <h2>Your Total Number of Affiliates: {{ $affiliates_count }} </h2>
                <a href="{{ URL::to('affiliates/add') }}" class="btn btn-primary text-center">Add New Affiliate</a>&nbsp;
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Affiliates</strong></div>
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
            <div class="panel-body table-responsive no-search">
                <form action="{{ URL::to('affiliates/payall') }}" class="form-inline" role="form" method="post">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="pull-right">
                    @if ($paid_affiliates = Session::get('paid_affiliates'))
                    <label>Payment was successful for {{ rtrim($paid_affiliates, ", ") }}.</label>
                    @endif
                    <button href="" class="btn btn-info " type="submit">Pay Affiliates</button>
                    </div>
                    <table class="table" class="display " cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Commission</th>
                            <th>Payout</th>
                            <th>Balance</th>
                            <th>Tracking Link(s)</th>
                            <!--<th>Redirect Link(s)</th>-->
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;?>
                        @foreach ($all_affiliates as $affiliate)
                        <?php $affiliate_row = $affiliate['row'];?>
                        <tr>
                            <td>
                                <label class="ui-checkbox"><input name="affiliate_ids[]" type="checkbox" value="{{ $affiliate_row->id }}"><span></span></label>
                            </td>
                            <td>{{ $affiliate_row->first_name }}</td>
                            <td>{{ $affiliate_row->last_name }}</td>
                            <td>{{ number_format($affiliate['commission'], 2) }}</td>
                            <td>{{ number_format($affiliate['payout'], 2)  }}</td>
                            <td>{{ number_format($affiliate['balance'], 2) }}</td>
                            <td>
                                @foreach ($affiliate['link'] as $link)
                                    <?php $track_link = 'https://' . $user_is['app_name'] . '.isrefer.com/go/' . $link['LocalUrl'] . '/' . $affiliate['AffCode']; ?>
                                    <input type="hidden" class="form-control" value="{{ $track_link }}" id="clip-{{ $link['LocalUrl'] }}" >
                                    <a class="copy-button" href="#" data-clipboard-target="clip-{{ $link['LocalUrl'] }}">{{ $link['Name'] }}</a> ({{ $track_link }})<br>
                                @endforeach
                            </td>
                            <!--
                            <td>
                                @foreach ($affiliate['link'] as $link)
                                    <a href="{{ $link['RedirectUrl'] }} " target="_blank">{{ $link['RedirectUrl'] }} </a><br>
                                @endforeach
                            </td>
                            -->
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
                </form>
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
                    alert ('Track link is copied to clipboard.');
                });
            });

            $('.table').DataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 5, 6 ] }
                ]
            });

            $('.input-daterange').datepicker({
                todayBtn: "linked"
            });
        });
    </script>
@endsection
@stop
