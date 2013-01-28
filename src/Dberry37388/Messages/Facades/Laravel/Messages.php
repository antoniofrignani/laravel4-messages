<?php namespace Dberry37388\Messages\Facades\Laravel;
/**
 * Part of the Messages Package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the MIT License.
 *
 * This source file is subject to the MIT License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://opensource.org/licenses/MIT
 *
 * @package    Messages
 * @version    1.0
 * @author     Daniel Berry
 * @license    MIT
 * @link       http://danielberry.me
 */

use Illuminate\Support\Facades\Facade;

class Messages extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'messages';
	}

}