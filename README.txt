OVERVIEW
--------

This theme delivers all the power of amazing Twitter Bootstrap web framework
directly to your Drupal site. It is lightweight, responsive and ready to use
out of the box. And perfect for subtheming as well.


FEATURES
--------

* Responsive layout
* [New] Built-in carousel animation for "Featured" region
* Amazing navbar with integrated logo, search box and main menu
* Main menu with dropdowns, unlimited nesting, headers and delimiters
* Elastic search box
* Affixed sidebars for table of contents, social plugins or something else
* Adjusted styles of pager and polls
* Perfect subtheming support


REQUIREMENTS
------------

* Libraries API
* jQuery 1.7.2
* Twitter Bootstrap 2.2.1


INSTALLATION
------------

1. Update jQuery to 1.7.2 version:

   * Install the latest dev version of the jQuery Update module.
   * Configure it to use jQuery version 1.7.
   * Download 1.7.2 versions of jquery.js and jquery.min.js.
   * Open modules/jquery_update/replace/jquery/1.7 and overwrite files there by their 1.7.2 versions.

2. Install Libraries API module.
3. Install Twitter Bootstrap library:

   * Download and unpack Twitter Bootstrap framework.
   * Place extracted files inside the folder sites/all/libraries.
   * Make sure that the bootstrap.css file is reachable at sites/all/libraries/bootstrap/css/bootstrap.css.

4. That's it! Enable Tweme.


CONFIGURATION
-------------

By default it will be used not minified version of Bootstrap. If you do not
prefer to compress JS and CSS files by the Drupal built-in compression and
aggregation system, you can manually replace bootstrap.js, bootstrap.css,
and bootstrap-responsive.css with their minified versions to run on the
production environment.


INFO
----

* Live demo: http://tonystar.ru
* Project home page: http://tonystar.ru/projects/tweme
* Created and maintained by: Anton Staroverov [tonystar]
  (http://drupal.org/user/787240)
