<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The core class for Gravatar images
 * Docs: http://en.gravatar.com/site/implement/url
 *
 * @package	Gravatar
 * @author	Dave Widmer
 */
class Gravatar_Core
{
	/**
	 * Constants for the rating system.
	 */
	const G = 'g';
	const PG = 'pg';
	const R = 'r';
	const X = 'x';

	/** @var	Service url. */
	protected $url = 'http://www.gravatar.com/avatar/';

	/** @var	Email address. */
	protected $email;

	/** @var	Configuration. */
	protected $config;

	/** @var	Instances for the gravatars. */
	protected static $instances = array();

	/** @var	Array of config options. */
	private $options = array( 'default','size','rating','alt','class' );

	/** @var	Array of default icons you can use. */
	private $icons = array( 'identicon', 'monsterid', 'wavatar', 404 );

	/**
	 * Gets an instance (or creates it first) with the given email
	 *
	 * @param		string	email address
	 * @param		string	configuration name
	 * @return	Gravatar_Core
	 */
	public static function instance($email, $config = 'default')
	{
		// Check for email key
		if( ! array_key_exists($email, self::$instances) ){
		// No key, create it
			new Gravatar_Core($email, $config);
		} else {
		// Email found, for that config?
			if( ! array_key_exists($config, self::$instances[$email]) ){
			// Doesn't exist in that config, need to create it
				new Gravatar_Core($email, $config);
			}
		}

		return self::$instances[$email][$config];
	}

	/**
	 * Creates a new Gravatar instance.
	 *
	 * @param string	Email to construct
	 * @param	string	Config name
	 */
	public function __construct($email, $name = 'default')
	{
		$this->email = $email;
		$this->config = Kohana::$config->load('gravatar')->$name;
		self::$instances[$email][$name] = $this;
	}

	/**
	 * Gets this instance as a string
	 * 
	 * @return	string		This instance as a string
	 */
	public function __toString()
	{
		return View::factory('gravatar')->set('gravatar', $this->build_view_props())->render();
	}

	/**
	 * Magic: getter
	 *
	 * @param		string	name
	 * @return	mixed		config value or NULL
	 */
	public function __get($name)
	{
		return ( in_array($name, $this->options) ) ?
						$this->config[$name] :
						NULL ;
	}

	/**
	 * Magic: setter
	 *
	 * @param string	name
	 * @param mixed		value
	 */
	public function __set($name, $val)
	{
		if( in_array($name, $this->options) ){
			$this->config[$name] = $val;
		}
	}

	/**
	 * Constructs the image url
	 * Docs: http://en.gravatar.com/site/implement/php
	 *
	 * @return	string		Image url
	 */
	private function _construct_url()
	{
		// Base url.
		$img = $this->url . md5( strtolower($this->email) ) . '.jpg';

		// Size - always there
		$img .= '?s=' . $this->config['size'];

		// Rating - always there
		$img .= '&r=' . $this->config['rating'];

		// Default image
		if( $this->config['default'] ){
			// Check for default icon, if not, then encode the url
			if( in_array($this->config['default'], $this->icons) ){
				$img .= '&d=' . $this->config['default'];
			} else {
				$img .= '&d=' . urlencode( $this->config['default'] );
			} 
		}

		// Return the url with the jpg extension
		return $img;
	}

	/**
	 * Builds the properties for the view.
	 *
	 * @return	stdClass	The properties object for the view
	 */
	protected function build_view_props()
	{
		$g = new stdClass;

		$g->url = $this->_construct_url();
		$g->width = $this->config['size'];
		$g->height = $this->config['size'];
		$g->alt = ( $this->config['alt'] ) ? $this->config['alt'] : '';
		$g->class = ( $this->config['class'] ) ? $this->config['class'] : '';

		return $g;
	}

} // End Gravatar_Core