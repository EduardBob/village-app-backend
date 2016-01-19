@extends('layouts.account')

@section('title')
{{ trans('user::auth.login') }} | @parent
@stop

@section('content')
<div class="header">{{ trans('user::auth.login') }}</div>
@include('flash::message')
{!! Form::open(['route' => 'login.post']) !!}
    <div class="body bg-gray">
        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            {!! Form::text('phone', Input::old('phone'), [
                'class' => 'form-control',
                'placeholder' => '+7',
                'data-inputmask' => '"mask": "'.config('village.user.phone.mask').'"',
                'data-mask' => ''
            ]) !!}
            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" name="password"
                   class="form-control" placeholder="Password"
                   value="{{ Input::old('password')}}"/>
            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group">
            <input type="checkbox" name="remember_me" id="remember_me"/>
            <label for="remember_me">{{ trans('user::auth.remember me') }}</label>
        </div>
    </div>
    <div class="footer">
        <button type="submit" class="btn btn-info btn-block">{{ trans('user::auth.login') }}</button>
{{--        <p><a href="{{URL::route('reset')}}">{{ trans('user::auth.forgot password') }}</a></p>--}}
{{--        <a href="{{URL::route('register')}}" class="text-center">{{ trans('user::auth.register')}}</a>--}}
    </div>
</form>

{!! HTML::script('themes/adminlte/js/vendor/input-mask/jquery.inputmask.js') !!}
{!! HTML::script('themes/adminlte/js/vendor/input-mask/jquery.inputmask.phone.extensions.js') !!}

<script>
    $( document ).ready(function() {
        $("[data-mask]").inputmask();
    });
</script>
@stop
