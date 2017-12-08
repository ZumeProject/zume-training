jQuery(function($) {

  $(".js-congratulations-more-button").on("click", function() {
    $(".js-congratulations-more-button").removeClass("active");
    $(this).addClass("active");
    var item = $(this).data("item");
    var textbox = $(".js-congratulations-more-item")
      .hide()
      .filter(function() { return $(this).data("item") == item; });
    textbox.show();
    $(this).blur();
    textbox.focus();
    if (! isScrolledIntoView(textbox[0])) {
      textbox[0].scrollIntoView({behavior: "smooth"});
    }
  });

  var group_permalink = $(".js-group-info").data("group-permalink");
  if (group_permalink) {
    var href = group_permalink + "group_invite_by_url/";
    $(".js-congratulations-more-invite-button").append(
      $("<p>").addClass("center").append(
       $("<a>").addClass("button").attr("href", href).text("Invite friends")
      )
    );
  }

  function isScrolledIntoView(el) {
    var rect = el.getBoundingClientRect();
    var isVisible = (rect.top >= 0) && (rect.bottom <= jQuery(document).height);
    return isVisible;
  }

});
