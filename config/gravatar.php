<?php defined('SYSPATH') or die('No direct script access.');
// Gravatar config array
return array
(
	'default' => array
	(
		'default'	=> 'wavatar',	// The default image, FALSE is the G, can also use identicon, monsterid, wavatar or 404
		'size'		=> 60,			// Size of the image in pixels
		'rating'	=> Gravatar::R,	// Default rating
		'class'		=> 'gravatar',		// The css class to apply, FALSE for none
		'alt'		=> FALSE,		// ALT tag for image, FALSE for empty string
	),
);
