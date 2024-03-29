@extends('backend.layouts.app')
@section('title') {{ __('system.pages') }}
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
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{__('system.category')}} - @if(isset($data)) {{ __('system.edit') }} @else {{ __('system.add') }} @endif
                            </h3>
                        </div>
                    </div>
                </div>
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
                            <label class="col-form-label col-lg-3 col-sm-12">Email *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <input type="text" class="form-control m-input" name="email" placeholder="Enter your email" data-toggle="m-tooltip" title="Tooltip description">
                                <span class="m-form__help">We'll never share your email with anyone else.</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">URL *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control m-input" name="url" placeholder="Enter your url">
                                    <div class="input-group-append"><span class="input-group-text">.via.com</span></div>
                                </div>
                                <span class="m-form__help">Please enter your website URL.</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Digits</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" name="digits" placeholder="Enter digits">
                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="la la-calculator"></i></span></span>
                                </div>
                                <span class="m-form__help">Please enter only digits</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Credit Card</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control m-input" name="creditcard" placeholder="Enter card number">
                                    <div class="input-group-append"><span class="input-group-text"><i class="la la-credit-card"></i></span></div>
                                </div>
                                <span class="m-form__help">Please enter your credit card number</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">US Phone</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control m-input" name="phone" placeholder="Enter phone">
                                    <div class="input-group-append"><a href="#" class="btn btn-brand"><i class="la la-phone"></i></a></div>
                                </div>
                                <span class="m-form__help">Please enter your US phone number</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Option *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <select class="form-control m-input" name="option">
                                    <option value="">Select</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                <span class="m-form__help">Please select an option.</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Options *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <select class="form-control m-input" name="options" multiple size="5">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                <span class="m-form__help">Please select at least one or maximum 4 options</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Memo *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <textarea class="form-control m-input" name="memo" placeholder="Enter a menu"></textarea>
                                <span class="m-form__help">Please enter a menu within text length range 10 and 100.</span>
                            </div>
                        </div>
                        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space"></div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Checkbox *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-checkbox-inline">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkbox"> Tick me
                                        <span></span>
                                    </label>
                                </div>
                                <span class="m-form__help">Please tick the checkbox</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Checkboxes *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkboxes"> Option 1
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkboxes"> Option 2
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkboxes"> Option 3
                                        <span></span>
                                    </label>
                                </div>
                                <span class="m-form__help">Please select at lease 1 and maximum 2 options</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Radios *</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="checkbox" name="radio"> Option 1
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="checkbox" name="radio"> Option 2
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="radio"> Option 3
                                        <span></span>
                                    </label>
                                </div>
                                <span class="m-form__help">Please select an option</span>
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
