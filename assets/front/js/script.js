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

    $(".tkt-child-department").hide();
    $(".tkt-child-department-" + value)
      .show()
      .prop("selectedIndex", 0);
  });
});
