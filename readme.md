Laravel 4 Messages Container
============================
This is a super simple messages container for Laravel 4. It allows you to add a message to a container and then either simply get it or render it using a view.

Installing
----------
Super simple to get this up and going.

1. Add ``` "dberry37388/messages": "dev-master" ``` to your composer.json
2. From the command line run ``` php composer.phar update ```
3. Add ``` 'Dberry37388\Messages\MessagesServiceProvider' ``` to your list of service providers in ```app/config/app.php```
4. Add ```'Messages' => 'Dberry37388\Messages\Facades\Laravel\Messages'``` to the list of class aliases in ```app/config/app.php```

Messages should now be up and running.

Using Messages
--------------

As I said, this is super super super simple setup. Feel free to make suggestions or additions. I created this to fill a need I had at the time.


###Adding Messages

```Message::add($message = '', $attributes = array(), $log = false)```

All that is required is the first parameter. This is the message that you want to add.

The second parameter is for any attributes that you want to pass. Here you can specify a container to add the message to, that way you can seperate your messages. Any additional attributes that you pass will be available. An example use case would be adding styles.

The third parameter ```$log``` allows you to also log the message to your logs. This uses the default Laravel Log.

```
Messages::add('message', array(
    'container' => 'whatever.container', // will use "default" if empty
    'styles'    => 'alert alert-error', // just an example of passng an extra attribute.
));
```


###Retrieving Messages

``Message::get($container = 'default')```
Grabs an array containing the message and attributes for a container.

```
$messages = Message::get('name_of_containter');
``` 

This will return an array that has your message and any attributes that you added for that container.


###Rendering Messages using View

```Message::render($view = '', $container = '')```
Renders the message container using the View that you specify.  Pass a view using Laravel's default notation e.g. messages.views

```
Messages::render('messages.templates.error', 'error');
```

This will return the view.