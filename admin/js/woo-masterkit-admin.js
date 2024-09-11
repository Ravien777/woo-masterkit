(function ($) {
  "use strict";

  jQuery(document).ready(function ($) {
    // Initialize Select2 for product selection
    $("#woo_masterkit_product_select").select2({
      ajax: {
        url: woo_masterkit_ajax.ajax_url,
        dataType: "json",
        delay: 250,
        data: function (params) {
          return {
            q: params.term,
            action: "woo_masterkit_search_products",
            nonce: woo_masterkit_ajax.nonce,
          };
        },
        processResults: function (data) {
          return {
            results: data,
          };
        },
        cache: true,
      },
      minimumInputLength: 2,
      placeholder: "Select products",
      allowClear: true,
    });
  });
})(jQuery);
