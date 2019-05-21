(function($, Drupal) {

    Drupal.behaviors.disablers = {
        attach: function disablers(context, settings) {
            $('#user-form :submit').unbind();
        }
    };
})(jQuery, Drupal);