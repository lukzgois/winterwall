@extends('layouts.login')

@section('content')
    <div class="LoginPanel">

        <h1>{{ trans('general.app-name') }}</h1>
        
        @if(Session::has('success'))
            <div class="LoginPanel__Success">
                {{ Session::get('success') }}
            </div>
        @endif

        <form action="{{ route('login.forgot-password') }}" method="post" class="Form">
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
            <div class="LoginPanel__FormActions">
                <button type="submit" class="btn btn-success">
                    {{ trans("buttons.send-password-recovery") }}
                </button>
            </div>
        </form>

        <hr />
        
        <div class="LoginPanel__UserActions">
            <a href="{{ route('login.index') }}">{{ trans('login.back-to-login') }}</a>
        </div>
    </div>
@endsection