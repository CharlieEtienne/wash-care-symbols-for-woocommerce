function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var baseUrl = "<?php echo plugin_dir_url( __FILE__ ) . 'symbols'; ?>";
    console.log(state.element.value);
    var $state = jQuery(
        '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
    );
    return $state;
}

jQuery(".wc-enhanced-select").selectWoo({
    templateResult: formatState
});