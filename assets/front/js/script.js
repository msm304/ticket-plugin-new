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
});
