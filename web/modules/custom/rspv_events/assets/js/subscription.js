(function ($, Drupal, drupalSettings) {
  "use strict";

  Drupal.behaviors.subscription = {
    attach: function attach(context) {
      const $subscribeButton = $('.node--view-mode-full > .btn-subscribe', context);
      const $participantsList = $('#participants', context);

      if ($subscribeButton.length) {
        $subscribeButton.click(function(){

          $subscribeButton.addClass('disabled');
          $subscribeButton.text('Wait...');

          $.ajax({
            url: Drupal.url('event/subscribe/' + $(this).data('event')),
            type:"GET",
            success: function(response) {
              if(response.error !== undefined){
                alert("An error has occurred. Try again later.")
              }
              else {
                const $action  = response.action;

                if ($action === 'register') {
                  $subscribeButton
                    .removeClass('btn-rspv-primary disabled')
                    .addClass('btn-warning');
                    $subscribeButton.text('Cancel subscription');
                    if($participantsList.length) {
                      $participantsList.append('<li id="user-'+response.user_id+'">'+response.user_name+'</li>');
                    }
                }
                else if ($action === 'remove') {
                  $subscribeButton
                  .removeClass('btn-warning disabled')
                  .addClass('btn-rspv-primary');
                  $subscribeButton.text('Join the event');
                  $('#user-'+response.user_id).remove();
                }
              }
            }
          });
          return false;
        })
      }
    }
  };

})(jQuery, Drupal);
