@extends('layouts.login')

@section('content')
    <div class="LoginPanel">
        <h1>{{ trans('register.register') }}</h1>

        <form action="{{ route('register.store') }}" method="post">
            {{ csrf_field() }}

            <div class="form-group {{ null != $errors->first('name') ? 'has-error' : '' }}">
                <input
                    class="form-control"
                    type="text"
                    placeholder="{{ trans('validation.attributes.name') }}"
                    name="name"
                    value="{{ old('name') }}"
                    autofocus />
                <span class="Form__Error">
                    {{ $errors->first('name') }}
                </span>
            </div>
            <div class="form-group {{ null != $errors->first('email') ? 'has-error' : '' }}">
                <input
                    class="form-control"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="{{ trans('validation.attributes.email') }}" />
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

            <div class="Form__Actions">
                <button type="submit" class="btn btn-success">
                    {{ trans('buttons.register') }}
                </button>
            </div>
        </form>

        <hr>

        <div class="LoginPanel__UserActions">
            <a href="{{ route('login.index') }}">
                {{ trans('register.already-registered') }}
            </a>
        </div>
    </div>
@endsection