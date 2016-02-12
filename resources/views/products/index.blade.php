@extends('app')
@section('title') @parent @stop
@section('styles')
<link rel="stylesheet" href="/assets/css/jquery.dataTables.css">
@endsection
@section('content')

<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Products</strong></div>
            <div class="panel-body table-responsive">
                <table class="table" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Sold Quantity</th>
                        <!--<th>Price</th>
                        <th>Taxable</th>
                        <th>Shippable</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;?>
                    @foreach ($products as $product)
                    @if ($product['Qty'] > 0)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $product['ProductName'] }}</td>
                        <td>{{ $product['Qty'] }}</td>
                        <!--<td>${{ $product['ProductPrice'] }}</td>
                        <td>{{ $product['Taxable'] ? 'Yes' : 'No' }}</td>
                        <td>{{ $product['Shippable'] ? 'Yes' : 'No' }}</td>-->
                    </tr>
                    @endif
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
    <script >
        $(document).ready(function() {
            $('.table').DataTable({
                //"lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]]
            });
        });
    </script>
@endsection
@stop
