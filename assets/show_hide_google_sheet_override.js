jQuery(document).ready(function() {
    const googleSheetOverride = jQuery('#carbon_fields_container_google_sheet_override');
    let checkbox = jQuery('input[name="carbon_fields_compact_input[_override_product_google_sheet_order_metas]"]:checked');

    checkbox.length > 0 ? googleSheetOverride.show() : googleSheetOverride.hide();

    jQuery('input[name="carbon_fields_compact_input[_override_product_google_sheet_order_metas]"]').on('change', function() {
        checkbox = jQuery('input[name="carbon_fields_compact_input[_override_product_google_sheet_order_metas]"]:checked');
        checkbox.length > 0 ? googleSheetOverride.show() : googleSheetOverride.hide();
    });
});