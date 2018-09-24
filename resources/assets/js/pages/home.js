'use strict';

(function () {
  $(document).on('click', '#top-menu-content a[href^="#"]', function (event) {
    event.preventDefault();
    $('html, body').animate({ scrollTop: $($.attr(this, 'href')).offset().top - 50 }, 500);
  });
})();
