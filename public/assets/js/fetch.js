$(document).ready(function() {

  $('[data-source-toggle]').click(function (e) {
    e.preventDefault();

    var $this = $(this)
      , data = $this.data('source-toggle');

    // Remove actively highlighted list item
    $this.siblings('.list-group-item.active').removeClass('active');

    // Highlight the currently selected list item
    $this.addClass('active');

    // Remove all previously highlighted tags
    $('#source .source-tag').removeClass('active');

    // Highlight the active tag in source element
    $('#source .source-tag-' + data).addClass('active');
  });

  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });

});
