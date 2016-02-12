@extends('app')
@section('title') Administrator @parent @stop
@section('content')
<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Users</strong></div>
            <div class="panel-body">
                <!--
                <a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-sm  btn-primary iframe">
                    <span class="glyphicon glyphicon-plus-sign"></span> New
                </a>-->
                <table id="table" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>App Name</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1;?>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->user->email }}</td>
                        <td>{{ $user->app_name }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <a href="{{ URL::to('admin/users/' . $user->user->id . '/edit') }}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                            @if ($user->id != 1)
                            <a href="{{ URL::to('admin/users/' . $user->user->id . '/delete') }}" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-remove"></span> Delete</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

@endsection
@stop