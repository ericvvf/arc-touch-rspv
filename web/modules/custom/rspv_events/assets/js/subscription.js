(function ($, Drupal, drupalSettings) {
  "use strict";

  Drupal.behaviors.subscription = {
    attach: function attach(context) {
      const $subscribeButton = $('.node--view-mode-full > .btn-join-event', context);
      const $participantsList = $('#participants', context);
      const $unsubscribeButton = $('.node--view-mode-full > .btn-leave-event', context);

      if ($subscribeButton.length) {
        $subscribeButton.click(function(){

          $subscribeButton.addClass('disabled');
          $subscribeButton.text('Subscribing...');

          $.ajax({
            url: Drupal.url('event/subscribe/' + $(this).data('event')),
            type:"GET",
            success: function(response) {
              if(response.error !== undefined){
                alert("An error has occurred. Try again later.")
              }
              else {
                $subscribeButton
                  .removeClass('btn-join-event btn-rspv-primary disabled')
                  .addClass('btn-warning btn-leave-event');

                  $subscribeButton.text('Cancel subscription');

                if($participantsList.length) {
                  $participantsList.append('<li id="user-'+response.user_id+'">'+response.user_name+'</li>');
                }
              }
            }
          });
          return false;
        })
      }

      if ($unsubscribeButton.length) {
        $unsubscribeButton.click(function(){
          alert("TOdo")
          return false;
        })
      }

    }
  };

})(jQuery, Drupal);
