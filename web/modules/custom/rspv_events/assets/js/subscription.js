(function ($, Drupal, drupalSettings) {
  "use strict";

  Drupal.behaviors.subscription = {
    attach: function attach(context) {
      const $subscribeButton = $('.node--view-mode-full > .btn-join-event', context);
      if ($subscribeButton.length) {
        $subscribeButton.click(function(){
          $.ajax({
            url: Drupal.url('event/subscribe/' + $(this).data('event')),
            type:"GET",
            success: function(response) {
              console.log(response)
            }
          });
          return false;
        })
      }
    }
  };

})(jQuery, Drupal);
