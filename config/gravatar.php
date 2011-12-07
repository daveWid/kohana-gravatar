<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	// Size of the image in pixels
	'size'    => 80,

	// The default image, FALSE is the G, can also use identicon, monsterid, wavatar, retro or 404
	'default_image' => false,

	// Default rating [Gravatar::G, Gravatar::PG, Gravatar::R, Gravatar::X]
	'rating'  => Gravatar::R,

	// Additional attributes that are added into the <img> tag
	'attrs'   => array(
		'class' => "gravatar",
		'alt' => "user gravatar"
	),
);