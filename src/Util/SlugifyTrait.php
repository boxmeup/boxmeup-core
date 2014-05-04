<?php

namespace Boxmeup\Util;

use \Cocur\Slugify\Slugify;

trait SlugifyTrait {

	/**
	 * Slugify a string.
	 *
	 * @param string $attributeName Which attribute to slugify from the context of this object.
	 * @param string $postfix String to append.
	 * @return string
	 */
	public function slugify($attributeName, $postfix = '') {
		return (new Slugify())->slugify($this[$attributeName]) . $postfix;
	}

}
