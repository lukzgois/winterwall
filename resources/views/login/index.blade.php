@extends('layouts.login')

@section('content')
    <div class="LoginPanel">

        <h1>{{ trans('general.app-name') }}</h1>
        
        <form action="{{ route('login.store') }}" method="post" class="Form">
            {{ csrf_field() }}
            <div class="form-group {{ null != $errors->first('email') ? 'has-error' : '' }}">
                <input
                    class="form-control"
                    type="email"
                    placeholder="{{ trans('validation.attributes.email') }}"
                    name="email"
                    value="{{ old('email') }}"
                    autofocus />
                <span class="Form__Error">
                    {{ $errors->first('email') }}
                </span>
            </div>
            <div class="form-group {{ null != $errors->first('password') ? 'has-error' : '' }}">
                <input
                    class="form-control"
                    type="password"
                    name="password"
                    placeholder="{{ trans('validation.attributes.password') }}" />
                <span class="Form__Error">
                    {{ $errors->first('password') }}
                </span>
            </div>

            <div class="LoginPanel__FormActions">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> {{ trans('validation.attributes.remember-me') }}
                    </label>
                </div>
                <button type="submit" class="btn btn-success">{{ trans("buttons.login") }}</button>
            </div>
        </form>

        <hr />
        
        <div class="LoginPanel__UserActions">
            <a href="#">{{ trans('login.forgot-password') }}</a>
            <a href="{{ route('register.index') }}">{{ trans('register.register') }}</a>
        </div>

    </div>
@endsection