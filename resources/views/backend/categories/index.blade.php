@extends('backend.layouts.app')
@section('title') {{ __('system.categories') }} - {{__('system.list')}} @endsection

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{route('dashboard')}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon flaticon-dashboard"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">&gt;</li>
                        <li class="m-nav__item">
                            <span class="m-nav__link-text">{{__('system.categories')}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                <div class="col-md-4">
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{__('system.category')}} {{__('system.add')}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <form method="post" id="category-create" class="m-form m-form--fit m-form--label-align-right">
                        <div class="m-portlet__body">

                            @csrf
                            <input type="hidden" name="job" value="createCategory">
                            <input type="hidden" name="id" value="0" id="cat-id">
                            <div class="form-group m-form__group">
                                <!--begin: Dropdown-->
                                <div class="m-dropdown  m-dropdown--arrow" m-dropdown-toggle="click">
                                    <div class="input-group">
                                        <input id="sscat" class="form-control m-input" placeholder="{{__('system.search')}}" type="text" autocomplete="off">
                                        <input id="sscat-selected" type="hidden" name="parent" value="0">
                                        <div id="sscat-deselect" class="input-group-append deselect-button sr-only">
                                            <button class="btn btn-secondary" type="button"><i class="flaticon-close"></i></button>
                                        </div>
                                    </div>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul id="sscat-results" class="m-nav">

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Dropdown-->
                            </div>
                            <div class="form-group m-form__group">
                                <input name="name" id="cat-name" class="form-control m-input" placeholder="{{__('system.title')}}" type="text">
                            </div>
                            <div class="form-group m-form__group">
                                <textarea name="description" id="cat-description" class="form-control m-input" placeholder="{{__('system.description')}}"></textarea>
                            </div>

                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions text-right">
                                <input type="reset" value="Sıfırla" class="btn btn-default reset-button">
                                <button type="submit" class="btn btn-primary active m-btn m-btn--icon">
									<span>
										<i class="flaticon-multimedia-2"></i>
										<span>{{__('system.save')}}</span>
									</span>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div id="column-1" class="col-md-4">
                    <div id="parent-0" class="multi-level-list" data-category-level="0">
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__body">
                                <ul class="parents">
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="javascript:;" id="cat-{{ $category->id }}" onclick="$.getSubCategories({{ $category->id }}, 0)">{{ $category->name }}</a>
                                            <a href="javascript:;" class="delete" onclick="$.deleteCategory({{ $category->id }})"><i class="flaticon-delete-2"></i></a><a href="javascript:;" class="edit" onclick="$.editCategory({{ $category->id }})"><i class="flaticon-edit"></i></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="column-2" class="col-md-4">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/selectCategory.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        (function ($) {
            var cl = 0;

            $.fn.mcHeight = function() {
                var h = 0;
                $(this).find(".multi-level-list").each(function () {
                    h += $(this).height();
                });

                return h;
            };

            $.getSubCategories = function(id, _cl) {
                $.startLoader();
                $(".multi-level-list").each(function () {
                    var that = $(this);

                    if (that.data("category-level") > _cl)
                        that.remove();
                });

                $.ajax({
                    type: "POST",
                    url: sherlock.ajax_url,
                    data: {_token: sherlock.token, job: "getSubCategories", id: id},
                    success: function(data) {
                        $.stopLoader();
                        if (!data.status) {
                            toastr.error(data.message);
                            return false;
                        }

                        if (_cl == cl)
                            cl++;
                        else
                            cl = _cl + 1;

                        $(".parent-categories").val(id);
                        if ($("#parent-" + data.data.subCategories[0].parent).length)
                            return false;

                        var html = "<div id=\"parent-" + data.data.subCategories[0].parent + "\" class=\"multi-level-list\" data-category-level=\"" + cl + "\"><div class=\"m-portlet m-portlet--mobile\"><div class=\"m-portlet__head\"><div class=\"m-portlet__head-caption\"><div class=\"m-portlet__head-title\"><h3 class=\"m-portlet__head-text\">" + data.data.category.name + " <span class=\"m-badge m-badge--danger m-badge--wide\">L" + cl + "</span></h3></div></div></div><div class=\"m-portlet__body\"><ul class=\"parents\">";

                        for(var x in data.data.subCategories) {
                            html += $.categoryListItem(data.data.subCategories[x]);
                        }

                        html += "</ul></div></div></div>";
                        var h1 = $("#column-1").mcHeight();
                        var h2 = $("#column-2").mcHeight();
                        if (h1 < h2)
                            $("#column-1").append(html);
                        else
                            $("#column-2").append(html);
                    },
                    error: function() {
                        $.stopLoader();
                    },
                    dataType: "json"
                });
            };

            $.editCategory = function(id) {
                $.ajax({
                    type: "POST",
                    url: sherlock.ajax_url,
                    data: {_token: sherlock.token, job: "getCategory", id: id},
                    success: function(data) {
                        $.stopLoader();
                        if (!data.status) {
                            toastr.error(data.message);
                            return false;
                        }

                        $("#cat-id").val(data.data.category.id);
                        $("#sscat").val(data.data.category.pathName).prop("disabled", true);
                        $("#sscat-selected").val(data.data.category.parent);
                        $("#sscat-deselect").removeClass("sr-only");
                        $("#cat-name").val(data.data.category.name);
                        $("#cat-description").val(data.data.category.description);
                    },
                    error: function() {
                        $.stopLoader();
                    },
                    dataType: "json"
                });
            };

            $.rebuildCategoryLists = function(category) {
                var html = $("#parent-" + category.parent).find(".parents").html();
                html += $.categoryListItem(category);
                $("#parent-" + category.parent).find(".parents").html(html);

                $(".parent-categories").find("li:last a").click();
            };

            $.categoryListItem = function(category) {
                return "<li><a href=\"javascript:;\" id=\"cat-" + category.id + "\" onclick=\"$.getSubCategories(" + category.id + ", " + cl + ")\">" + category.name + "</a><a href=\"javascript:;\" class=\"delete\" onclick=\"$.deleteCategory(" + category.id + ")\"><i class=\"flaticon-delete-2\"></i></a><a href=\"javascript:;\" class=\"edit\" onclick=\"$.editCategory(" + category.id + ")\"><i class=\"flaticon-edit\"></i></a></li>";
            };

            $(function () {
                $("#category-create").submit(function () {
                    $.startLoader();
                    var that = $(this);

                    $.ajax({
                        type: "POST",
                        url: sherlock.ajax_url,
                        data: that.serialize(),
                        success: function(data) {
                            if (data.status) {
                                toastr.success(data.message);
                                that.find(".reset-button").click();
                            } else
                                toastr.error(data.message);

                            $("#cat-" +  data.data.newCategory.id).remove();
                            $.rebuildCategoryLists(data.data.newCategory);
                            $.stopLoader();
                        },
                        error: function() {
                            $.stopLoader();
                        },
                        dataType: "json"
                    });

                    return false;
                });

                $("#sscat").getSelectCategory();
            });
        })(jQuery);
    </script>
@endsection
