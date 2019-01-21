(function ($) {
    "use strict";

    $.fn.getSelectCategory = function() {
        var that = $(this);

        that.keyup(function () {
            var v = that.val();

            that.parent().parent().removeClass("m-dropdown--open");
            $("#" + that.attr("id") + "-results").html("");

            if (v.length < 2)
                return;

            $.ajax({
                type: "POST",
                url: sherlock.ajax_url,
                data: {_token: sherlock.token, job: "getSelectCategories", query: v},
                success: function(data) {
                    if (!data.status)
                        return false;

                    var html = "";
                    for (var x in data.data.categories) {
                        html += "<li class=\"m-nav__item\"><a href=\"javascript:;\" class=\"m-nav__link\" data-toggle=\"m-tooltip\" title=\"" + data.data.categories[x].name + "\" onclick=\"$.selectAsCategory('" + that.attr("id") + "', '" + data.data.categories[x].id + "', '" + data.data.categories[x].pathName + "')\"><span class=\"m-nav__link-text\">" + data.data.categories[x].pathName + "</span></a></li>";
                    }

                    $("#" + that.attr("id") + "-results").html(html);
                    that.parent().parent().addClass("m-dropdown--open");
                },
                dataType: "json"
            });
        });

        // that.blur(function () {
        //     that.parent().removeClass("m-dropdown--open");
        //     $("#" + that.attr("id") + "-results").html("");
        //     that.val("");
        // });
    };

    $.selectAsCategory = function(sbid, id, pathName) {
        var that = $("#" + sbid);

        that.val(pathName).prop("disabled", true);
        $("#" + sbid + "-selected").val(id);
        that.parent().parent().removeClass("m-dropdown--open");
        $("#" + sbid + "-results").html("");
        $("#" + sbid + "-deselect").removeClass("sr-only");
    };

    $.deselectCategory = function(sbid) {
        var that = $("#" + sbid);
        that.val("").prop("disabled", false);
        $("#" + sbid + "-selected").val(0);
        $("#" + sbid + "-deselect").addClass("sr-only");
    };

    $(function () {
        $(".deselect-button").click(function () {
            var sbid = $(this).attr("id").replace("-deselect", "");
            $.deselectCategory(sbid);
        });
    });
})(jQuery);