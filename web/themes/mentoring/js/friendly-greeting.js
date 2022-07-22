(function (Drupal) {
    // If we have a nice user name, let's replace the
    // site name with a greeting.
    if (drupalSettings.mentoring.name) {
      var siteName = document.getElementsByClassName('site-name')[0];
      siteName.getElementsByTagName('a')[0].innerHTML = 'Howdy, ' + drupalSettings.mentoring.name + '!';
    }
  })(Drupal);