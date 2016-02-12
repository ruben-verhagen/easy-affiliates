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

                <form id="deleteForm" class="form-horizontal" method="post"
                      action="@if (isset($user)){{ URL::to('admin/users/' . $user->id . '/delete') }}@endif"
                      autocomplete="off">

                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <input type="hidden" name="id" value="{{ $user->id }}" />
                    <div class="form-group">
                        <div class="controls">
                            {{ Lang::get("admin/modal.delete_message") }}<br>
                            <a href="{{ URL::to('/admin/users') }}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</a>
                            <button type="submit" class="btn btn-sm btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> {{
                                Lang::get("admin/modal.delete") }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

@endsection
@stop

