@extends('app')
@section('title') Administrator @parent @stop
@section('content')
<section id="content" class="content-container animate-fade-up">
    <div class="page page-dashboard" data-ng-controller="DashboardCtrl">

        <div class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Users</strong></div>
            <div class="panel-body">
                <form class="form-horizontal" method="post"
                      action="@if (isset($user)){{ URL::to('admin/users/' . $user->id . '/edit') }}@else#@endif"
                      autocomplete="off">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                    @if(!isset($user))
                    <div class="form-group {{{ $errors->has('username') ? 'has-error' : '' }}}">
                        <label class="col-md-2 control-label" for="username">{{
                            Lang::get('admin/users.username') }}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="username" tabindex="4"
                                   placeholder="{{ Lang::get('admin/users.username') }}" name="username"
                                   id="username"
                                   value="{{{ Input::old('username', isset($user) ? $user->username : null) }}}" />
                            {!! $errors->first('username', '<label class="control-label"
                                                                   for="username">:message</label>')!!}
                        </div>
                    </div>
                    <div class="form-group {{{ $errors->has('email') ? 'has-error' : '' }}}">
                        <label class="col-md-2 control-label" for="email">{{
                            Lang::get('admin/users.email') }}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="email" tabindex="4"
                                   placeholder="{{ Lang::get('admin/users.email') }}" name="email"
                                   id="email"
                                   value="{{{ Input::old('email', isset($user) ? $user->email : null) }}}" />
                            {!! $errors->first('email', '<label class="control-label"
                                                                for="email">:message</label>')!!}
                        </div>
                    </div>
                    @endif
                    <div class="form-group {{{ $errors->has('password') ? 'has-error' : '' }}}">
                        <label class="col-md-2 control-label" for="password">{{
                            Lang::get('admin/users.password') }}</label>
                        <div class="col-md-10">
                            <input class="form-control" tabindex="5"
                                   placeholder="{{ Lang::get('admin/users.password') }}"
                                   type="password" name="password" id="password" value="" />
                            {!!$errors->first('password', '<label class="control-label"
                                                                  for="password">:message</label>')!!}
                        </div>
                    </div>
                    <div class="form-group {{{ $errors->has('password_confirmation') ? 'has-error' : '' }}}">
                        <label class="col-md-2 control-label" for="password_confirmation">{{
                            Lang::get('admin/users.password_confirmation') }}</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" tabindex="6"
                                   placeholder="{{ Lang::get('admin/users.password_confirmation') }}"
                                   name="password_confirmation" id="password_confirmation" value="" />
                            {!!$errors->first('password_confirmation', '<label
                                class="control-label" for="password_confirmation">:message</label>')!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="confirm">{{
                            Lang::get('admin/users.activate_user') }}</label>
                        <div class="col-md-6">
                            <select class="form-control" name="confirmed" id="confirmed">
                                <option value="1" {{{ ((isset($user) && $user->confirmed == 1)? '
                                selected="selected"' : '') }}}>{{{ Lang::get('admin/users.yes')
                                }}}</option>
                                <option value="0" {{{ ((isset($user) && $user->confirmed == 0) ?
                                ' selected="selected"' : '') }}}>{{{ Lang::get('admin/users.no')
                                }}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="roles">{{
                            Lang::get('admin/users.roles') }}</label>
                        <div class="col-md-6">
                            <select name="roles[]" id="roles" multiple style="width: 100%;">
                                @foreach ($roles as $role)
                                <option value="{{{ $role->id }}}" {{{ ( array_search($role->id,
                                $selectedRoles) !== false && array_search($role->id,
                                $selectedRoles) >= 0 ? ' selected="selected"' : '') }}}>{{{
                                $role->name }}}</option> @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="reset" class="btn btn-sm btn-default">
                                <span class="glyphicon glyphicon-remove-circle"></span>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-sm btn-success">
                                <span class="glyphicon glyphicon-ok-circle"></span>
                                @if	(isset($user))
                                    Save
                                @else
                                    Create
                                @endif
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

