@extends('backend.layouts.app', ['sidebar' => false, 'header' => false, 'footer' => false])

@section('content')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url('{{ asset('images/bg-2.jpg') }}');">
    <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
        <div class="m-login__container">
            <div class="m-login__logo">
                <a href="#">
                    <img src="{{ asset('images/logo.png') }}">
                </a>
            </div>
            <div class="m-login__signin">
                <form class="m-login__form m-form" action="" method="post">
                    @csrf
                    <div class="form-group m-form__group">
                        <input type="email" class="form-control m-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" required autofocus>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif

                    </div>
                    <div class="form-group m-form__group">
                        <input type="password" class="form-control m-input m-login__form-input--last{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required>

                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row m-login__form-sub">
                        <div class="col m--align-left m-login__form-left">
                            <label class="m-checkbox  m-checkbox--light">
                                <input type="checkbox" name="remember"{{ old('remember') ? ' checked' : '' }}> {{ __('Remember Me') }}
                                <span></span>
                            </label>
                        </div>
                        <div class="col m--align-right m-login__form-right">
                            <a href="javascript:;" id="m_login_forget_password" class="m-link">Forget Password?</a>
                        </div>
                    </div>
                    <div class="m-login__form-action">
                        <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">{{ __('Login') }}</button>
                    </div>
                </form>
            </div>
            <div class="m-login__signup">
                <div class="m-login__head">
                    <h3 class="m-login__title">Sign Up</h3>
                    <div class="m-login__desc">Enter your details to create your account:</div>
                </div>
                <form class="m-login__form m-form" action="">
                    <div class="form-group m-form__group">
                        <input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
                    </div>
                    <div class="form-group m-form__group">
                        <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                    </div>
                    <div class="form-group m-form__group">
                        <input class="form-control m-input" type="password" placeholder="Password" name="password">
                    </div>
                    <div class="form-group m-form__group">
                        <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
                    </div>
                    <div class="row form-group m-form__group m-login__form-sub">
                        <div class="col m--align-left">
                            <label class="m-checkbox m-checkbox--light">
                                <input type="checkbox" name="agree">I Agree the <a href="#" class="m-link m-link--focus">terms and conditions</a>.
                                <span></span>
                            </label>
                            <span class="m-form__help"></span>
                        </div>
                    </div>
                    <div class="m-login__form-action">
                        <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign Up</button>&nbsp;&nbsp;
                        <button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="m-login__forget-password">
                <div class="m-login__head">
                    <h3 class="m-login__title">Forgotten Password?</h3>
                    <div class="m-login__desc">Enter your email to reset your password:</div>
                </div>
                <form class="m-login__form m-form" action="">
                    <div class="form-group m-form__group">
                        <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                    </div>
                    <div class="m-login__form-action">
                        <button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Request</button>&nbsp;&nbsp;
                        <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
