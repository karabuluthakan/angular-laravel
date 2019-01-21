@extends('backend.layouts.app')
@section('title') {{ __('posts') }}
    @if(isset($data)) {{ __('system.edit') }} @else {{ __('system.add') }} @endif
@endsection
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="{{route('dashboard')}}" class="m-nav__link">
                                <span class="m-nav__link-text">{{__('system.dashboard')}}</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="{{route('categories.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">{{__('system.categories')}}</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            @if(isset($data))
                                <a href="{{route('categories.update')}}" class="m-nav__link">
                                    <span class="m-nav__link-text">{{__('system.edit')}}</span>
                                </a>
                            @else
                                <a href="{{route('categories.create')}}" class="m-nav__link">
                                    <span class="m-nav__link-text">{{__('system.add')}}</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <!--begin::Form-->
                <form class="m-form m-form--fit m-form--label-align-right" id="m_form_1">
                    <div class="m-portlet__body">
                        <div class="m-form__content">
                            <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
                                <div class="m-alert__icon">
                                    <i class="la la-warning"></i>
                                </div>
                                <div class="m-alert__text">
                                    Oh snap! Change a few things up and try submitting again.
                                </div>
                                <div class="m-alert__close">
                                    <button type="button" class="close" data-close="alert" aria-label="Close">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-md-3 col-xm-12">{{ __('system.title') }} *</label>
                            <div class="col-lg-8 col-md-7 col-xs-12">
                                <input type="text" class="form-control m-input" name="title" placeholder="{{ __('system.title') }}" data-toggle="m-tooltip" title="{{ __('info.post_title') }}">
                                {{--<span class="m-form__help">We'll never share your email with anyone else.</span>--}}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-md-3 col-xm-12">{{ __('system.short_description') }}</label>
                            <div class="col-lg-8 col-md-7 col-xs-12">
                                <textarea type="text" class="form-control m-input" name="description" data-toggle="m-tooltip" title="{{ __('info.post_description') }}"></textarea>
                                {{--<span class="m-form__help">We'll never share your email with anyone else.</span>--}}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-2 col-md-3 col-xm-12">{{ __('system.body') }}</label>
                            <div class="col-lg-8 col-md-7 col-xs-12">
                                <textarea type="text" class="form-control m-input" name="body" data-toggle="m-tooltip" title="{{ __('info.post_body') }}"></textarea>
                                {{--<span class="m-form__help">We'll never share your email with anyone else.</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">
                                    <button type="submit" class="btn btn-success">Validate</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
@endsection
