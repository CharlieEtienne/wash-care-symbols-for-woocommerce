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
    });

    function formatState(opt) {
        if (!opt.id) {
            return opt.text;
        }

        // noinspection JSUnresolvedVariable
        return $(
            '<img src="' + symbols_dir + opt.id + '.png" height="38px" alt="" style="vertical-align:middle;" /> <span style="vertical-align:middle;">' + opt.text + '</span>'
        );
    }

})(jQuery);