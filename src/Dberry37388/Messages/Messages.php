<?php namespace Dberry37388\Messages;

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

use Session, View, Log;

class Messages
{
	/**
	 * Holds our messages
	 * @var array
	 */
	protected static $messages = array();

	/**
	 * Name of the container holding our Flashed Messages
	 * @var string
	 */
	protected static $flash_container = 'embark';

	/**
	 * Holds our Session Flashed message
	 * @var array
	 */
	protected static $new_flash_messages = array();

	/**
	 * Checks to see if we have retrieved our flash messages
	 * or not.
	 * @var boolean
	 */
	protected static $init = false;



	/**
	 * Adds a message to the Messages Container
	 *
	 * All that is required is the first parameter. This is the message that
	 * you want to add.
	 *
	 * The second parameter is for any attributes that you want to pass. Here you
	 * can specify a container to add the message to, that way you can seperate your
	 * messages. Any additional attributes that you pass will be available. An
	 * example use case would be adding styles.
	 *
	 * <code>
	 * Messages::add('message', array(
	 * 	'container' => 'whatever.container', // will use "default" if empty
	 * 	'styles'    => 'alert alert-error', // just an example of passng an extra attribute.
	 * ));
	 * </code>
	 * 
	 * @param mixed   $messages    message(s) to add
	 * @param array   $attributes  use this to pass additional attributes
	 * @param boolean $log         should this be logged as well as displayed
	 */
	public function add($messages, $attributes = array(), $log = false)
	{
		if (empty($messages))
		{
			return;
		}

		$flash = array_get($attributes, 'flash', true);
		$container = array_get($attributes, 'container', '');

		if ($flash == true)
		{
			// creates our message to add to the flash container
			self::$new_flash_messages[$container] = array(
				'message'    => $messages,
				'attributes' => $attributes
			);

			// check to see if we need to log this message
			if ($log === true)
			{
				Log::write($container, $messages);
			}

			// adds our messages to the session flash container
			Session::flash(self::$flash_container, self::$new_flash_messages);
		}
		else
		{
			// creates our message to add to the flash container
			self::$messages[$container] = array(
				'message'    => $messages,
				'attributes' => $attributes
			);
		}
	}


	/**
	 * Gets messages for the specified container.
	 *
	 * Grabs an array containing the message and attributes for
	 * a container 
	 *
	 * <code>
	 * $messages = Message:;get('default');
	 * </code>
	 * 
	 * @param  string  $container  name of the container to fetch
	 * @return array
	 */
	public function get($container = 'default')
	{
		if ( ! self::$init)
		{
			// retrieve our stored session flash messages
			$flash_messages = Session::get(self::$flash_container);

			if ($flash_messages)
			{
				foreach ($flash_messages as $flash_container => $attributes)
				{
					foreach ($attributes as $attribute)
					{
						self::$messages[$flash_container] = $attributes;
					}
				}

				// this means we've retrieved our messages stored in flash.
				self::$init = true;
			}
		}

		if ( ! empty($container))
		{
			return (isset(self::$messages[$container])) ? self::$messages[$container] : array();
		}
		else
		{
			return self::$messages;
		}
	}


	/**
	 * Uses view to render a message
	 *
	 * Renders the message container using the View that you
	 * specify.  Pass a view using Laravel's default notation,
	 * e.g. messages.views
	 *
	 * <code>
	 * Messages::render('messages.templates.error', 'error');
	 * </code>
	 * 
	 * @param  string  $view      the view you want to use
	 * @param  string  $container container to grab
	 * @return View
	 */
	public function render($view, $container = '')
	{
		// get our messages
		$messages = self::get($container);

		if ( ! empty($messages['message']))
		{
			if ( ! is_array($messages['message']))
			{
				$messages['message'] = array($messages['message']);
			}

			if ( ! empty($messages))
			{
				// return our view
				return View::make($view, array(
					'messages' => $messages['message'],
					'attributes' => $messages['attributes']
				));
			}
		}
	}

}