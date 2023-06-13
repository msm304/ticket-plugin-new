jQuery(document).ready(function ($) {
  $(".tkt-fags h5").click(function (e) {
    e.preventDefault();

    let $this = $(this);

    $this.next("p").slideToggle();
    $this.parentsUntil(".tkt-fags").toggleClass("tkt-collapse");
  });
  $("#tkt-parent-department").change(function (e) {
    e.preventDefault();

    let $this = $(this);
    let value = $this.val();

    if (value === "") {
      $(".tkt-child-department").hide();
      $(".tkt-child-department-0").show();

      return false;
    }
    $(".tkt-description-wrapper").hide();
    $(".tkt-child-department").hide();
    $(".tkt-child-department-" + value)
      .show()
      .prop("selectedIndex", 0);
  });
  $(".tkt-child-department").change(function (e) {
    e.preventDefault();

    let $this = $(this);
    let value = $this.val();

    $(".tkt-description-wrapper").hide();
    $(".tkt-description-wrapper-" + value).show();
  });
  $("#tkt-submit-ticket").submit(function (e) {
    e.preventDefault();

    let $this = $(this);

    let submit = $this.find(".tkt-submit");
    let loader = $this.find(".tkt-loader");

    submit.prop("disabled", true);
    loader.show();

    form_data = new FormData();
    form_data.append("action", "tkt_submit_ticket");
    form_data.append("nonce", TKT_DATA.nonce);
    form_data.append("parent_department", $("#tkt-parent-department").val());
    form_data.append(
      "child_department",
      $(".tkt-child-department:visible").val()
    );
    form_data.append("title", $("#tkt-title").val());
    form_data.append("priority", $("#tkt-priority").val());
    form_data.append("body", $("#tkt-content").val());
    form_data.append("file", $("#tkt-file").prop("files")[0]);

    $.ajax({
      type: "post",
      url: TKT_DATA.ajax_url,
      data: form_data,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.__success) {
          // Swal.fire("تیکت ارسال شد", "تیکت شما با موفقیت ثبت شد", "success");
          window.location.href = response.results;
        } else {
          Swal.fire("ارسال ناموفق", "تیکت ارسال نشد", "error");
        }
      },
      error: function (error) {},
      complete: function () {
        submit.prop("disabled", false);
        loader.hide();
      },
    });
  });
});
