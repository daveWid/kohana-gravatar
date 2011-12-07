# Gravatar

The gravatar module allows you to easily interact with [gravatar.com](http://www.gravatar.com) to display user icons.

## Configuration

The default configuration file is located in `MODPATH/gravatar/config/gravatar.php`. You should copy this file to `APPPATH/config/gravatar.php` and make changes there, in keeping with the [cascading filesystem](../kohana/files).

Below is a list of the configuration options:

Name | Type | Default | Description
-----|------|---------|------------
default | `string` | wavatar | The default image, FALSE is the Gravatar G icon. Your can also use a url to your own image, 404, mm, identicon, monsterid, wavatar or retro.
size | `int` | 60 | The size of the image in pixels. This number must be between 1 and 512.
rating | `string` |	[Gravatar::R] | The default maximum rating for the image.
attrs | `array` | array('class' => "gravatar", 'alt' => "user gravatar") | Optional, additional key/value attributes to include in the <img> tag.

Take a look at the [documentation](http://en.gravatar.com/site/implement/images/) on the Gravatar site for more information.

## Displaying Icons

To display a gravatar icon all you need to do is echo out a Gravatar instance.

~~~
// Display the icon for test@example.com
echo Gravatar::instance('test@example.com');
~~~

Using [Gravatar::instance] will cache the calls to gravatar so you won't need to keep hitting their server for the same email address.

## Extending

If you see features that are missing or you want to help make this module better, the code is hosted on [github](https://github.com/daveWid/kohana-gravatar). Fork and hack away!

---

Developed by [Dave Widmer](http://www.davewidmer.net)