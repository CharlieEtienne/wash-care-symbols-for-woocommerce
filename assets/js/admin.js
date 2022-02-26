// noinspection JSUnresolvedVariable

(function ($) {

    "use strict";

    $(document).ready(function () {
        $(document.body).on('wc-init-tabbed-panels', function () {
            // Gets rid of selectWoo on WCSFW fields and loads a modified copy of select2.js
            // in order to add symbols in dropdowns and selected options, which is not possible with selectWoo since v1.07
            // See https://github.com/woocommerce/selectWoo/issues/39
            $(document).find("select.wcsfw")
                .selectWoo('destroy')
                .select_wcsfw({
                    templateResult: formatState,
                    templateSelection: formatState
                });
        });

        if (wcsfw_page_type[0] && wcsfw_page_type[0] ==="product_cat_edit"){
            $(document).find("select.wcsfw").select_wcsfw({
                    templateResult: formatState,
                    templateSelection: formatState
                });
        }

        $('#wcsfw_use_at_cat_level').on('change', function (e) {
            if($(this).prop('checked')) {
                $('.wcsfw-cat-field').show();
            } else {
                $('.wcsfw-cat-field').hide();
            }
        }).trigger('change');
    });

    function formatState(opt) {
        if (!opt.id || !symbols_dir[0]) {
            return opt.text;
        }

        return $(
            '<img src="' + symbols_dir[0] + opt.id + '.png" height="38px" alt="" style="vertical-align:middle;" /> <span style="vertical-align:middle;">' + opt.text + '</span>'
        );
    }

})(jQuery);