<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Gravatar icons for your site.
 *
 * @see       http://en.gravatar.com/site/implement/images/
 *
 * @package   Gravatar
 * @author    Dave Widmer <dave@davewidmer.net>
 */
class Gravatar_Core
{
	/**
	 * Suitable for display on all websites with any audience type
	 */
	const G = 'g';

	/**
	 * May contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence
	 */
	const PG = 'pg';

	/**
	 * May contain such things as harsh profanity, intense violence, nudity, or hard drug use
	 */
	const R = 'r';

	/**
	 * May contain hardcore sexual imagery or extremely disturbing violence
	 */
	const X = 'x';

	/**
	 * The url to the gravatar service
	 */
	const URL = "http://www.gravatar.com/avatar/";

	/**
	 * The url for the gravatar service (using ssl)
	 */
	const SECURE_URL = "https://secure.gravatar.com/";

	/**
	 * @var   array   List of Gravatar objects
	 */
	protected static $_instances = array();

	/**
	 * Gets an instance (or creates it first) with the given email
	 *
	 * @param   string   $email   Email addrewss
	 * @return  Gravatar
	 */
	public static function instance($email)
	{
		if ( ! isset(self::$_instances[$email]))
		{
			self::$_instances[$email] = new Gravatar($email);
		}

		return self::$_instances[$email];
	}

	/**
	 * @var   string   The email address
	 */
	protected $_email;

	/**
	 * @var   array    Configuration options.
	 */
	protected $_config;

	/**
	 * @var   string   The last url that was built
	 */
	protected $_last_url = null;

	/**
	 * @var   boolean  Has any of the url data changed since the last url() call?
	 */
	protected $_has_changed = true;

	/**
	 * Creates a new Gravatar instance.
	 *
	 * @param   string   $email  Email address
	 */
	public function __construct($email)
	{
		$this->_email = $email;
		$this->_config = Kohana::$config->load('gravatar');
	}

	/**
	 * Gets the HTML to display the image.
	 *
	 * @return   string
	 */
	public function render()
	{
		return HTML::image($this->url(), $this->_config['attrs'] + array(
			'width' => $this->_config['size'],
			'height' => $this->_config['size'],
		));
	}

	/**
	 * Gets this HTML to display the image.
	 *
	 * @return   string
	 */
	public function __toString()
	{
		return $this->render();
	}

	/**
	 * Gets the email address associated with this instance.
	 *
	 * @return   string
	 */
	public function email()
	{
		return $this->_email;
	}

	/**
	 * Gets the url for the image.
	 *
	 * @see     http://en.gravatar.com/site/implement/images/php/
	 *
	 * @return  string   Gravatar image url
	 */
	public function url()
	{
		// Check to see if the url has been built and nothing changed
		// If so, just return the url instead of rebuilding it
		if ($this->_last_url !== null AND ! $this->_has_changed)
		{
			return $this->_last_url;
		}

		$url = (isset($_SERVER['HTTPS']) OR $_SERVER['SERVER_PORT'] === 443) ? self::SECURE_URL : self::URL;
		$url .= md5(strtolower($this->_email)).'.jpg';

		$props = array(
			's' => $this->_config['size'],
			'r' => $this->_config['rating'],
		);

		if ($this->_config['default_image'] !== false)
		{
			$props['d'] = urlencode($this->_config['default_image']);
		}

		$this->_last_url = $url."?".http_build_query($props);
		$this->_has_changed = false;

		return $this->_last_url;
	}

	/**
	 * Get or set the size of the icon.
	 *
	 * @throws  Exception
	 *
	 * @param   int   $value   The size of the image (ssetter)
	 * @return  int            The size of the image (getter)
	 * @return  Gravatar       This object (setter)
	 */
	public function size($value = null)
	{
		if ($value !== null)
		{
			if ($value < 1 OR $value > 512)
			{
				throw new Exception("The Gravatar icon size must be between 1 and 512 pixels");
			}
		}

		return $this->getter_setter('size', $value);
	}

	/**
	 * Get or set the default image.
	 *
	 * @param   string   $value  The default image (ssetter)
	 * @return  string           The default image (getter)
	 * @return  Gravatar         This object (setter)
	 */
	public function default_image($value = null)
	{
		return $this->getter_setter('default_image', $value);
	}

	/**
	 * Get or set the icon rating.
	 *
	 * @param   string   $value  The rating of the image (ssetter)
	 * @return  string           The rating of the image (getter)
	 * @return  Gravatar       This object (setter)
	 */
	public function rating($value = null)
	{
		return $this->getter_setter('rating', $value);
	}

	/**
	 * Get or set the image attributes.
	 *
	 * @param   array   $value  Image attributes (setter)
	 * @return  array           Image attributes (getter)
	 * @return  Gravatar        This object (setter)
	 */
	public function attrs($value = null)
	{
		return $this->getter_setter('attrs', $value);
	}

	/**
	 * A vanilla getter/setter function for a lot of properties in this class
	 *
	 * @param    string   $property   The config property to get
	 * @param    string   $value      The value to set | if null, it will get the value
	 * @return   mixed                The value of the property (getter)
	 * @return   Gravatar             This object (setter)
	 */
	protected function getter_setter($property, $value)
	{
		if ($value !== null)
		{
			$this->_config[$property] = $value;
			$this->_has_changed = true;
			return $this;
		}
		else
		{
			return $this->_config[$property];
		}
	}

} // End Gravatar_Core
