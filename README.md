# Gravatar

The gravatar module allows you to easily interact with [gravatar.com](http://www.gravatar.com) to display user icons.

## Configuration

The default configuration file is located in `MODPATH/gravatar/config/gravatar.php`. You should copy this file to `APPPATH/config/gravatar.php` and make changes there, in keeping with the [cascading filesystem](http://kohanaframework.org/3.2/guide/kohana/files).

Below is a list of the configuration options:

Name | Type | Default | Description
-----|------|---------|------------
default_image | `string` | false | The default image, FALSE is the Gravatar G icon. Your can also use a url to your own image, 404, mm, identicon, monsterid, wavatar or retro.
size | `int` | 60 | The size of the image in pixels. This number must be between 1 and 512.
rating | `string` |	Gravatar::R | The default maximum rating for the image.
attrs | `array` | array('class' => "gravatar", 'alt' => "user gravatar") | Optional, additional key/value attributes to include in the <img> tag.

Take a look at the [documentation](http://en.gravatar.com/site/implement/images/) on the Gravatar site for more information.

## Displaying Icons

~~~
// Display the icon for test@example.com
echo Gravatar::instance('test@example.com');

// You can also use render
Gravatar::instance('test@example.com')->render();
~~~

Using `Gravatar::instance` will keep the Gravatar objects around so you won't have duplicate objects for the same email.

## Extending

If you see features that are missing or you want to help make this module better, the code is hosted on [github](https://github.com/daveWid/kohana-gravatar). Fork and hack away!

---

Developed by [Dave Widmer](http://www.davewidmer.net)