jQuery(document).ready(function ($) {
  let answerable = $("#department-answerable");
  answerable.select2({
    ajax: {
      url: TKT_DATA.ajax_url,
      dataType: "json",
      delay: 250,
      type: "post",
      timeout: 20000,
      data: function (params) {
        return {
          term: params.term,
          action: "tkt_search_users",
        };
      },
      processResults: function (data) {
        var items = [];
        if (data) {
          $.each(data, function (index, user) {
            items.push({ id: user[0], text: user[1] });
          });
          }
          
          return {
              results: items,
          }

      },
      cache: true,
    },
  });
});
