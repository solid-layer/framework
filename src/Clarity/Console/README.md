# Clarity Console

use this to build your own console command for your Phalcon applications.

## Console

Let's create a simple console

```php
<?php

use Clarity\Console\SlayerCommand;

class SampleConsole extends SlayerCommand
{
    protected $alias = 'sample';
    protected $description = 'Just a sample class to test console';

    public function slash()
    {
        $this->comment('triggered!');
    }
}
```

Save the file as ``SampleConsole.php``


---


## Bootstrap

Let's bootstrap the application on how we could probably create the executor.

```php
#!/usr/bin/env php
<?php

$consoles = [
    SampleConsole::class,
];

use Symfony\Component\Console\Application;
$app = new Application(
    'Brood (c) Daison Cariño',
    'v0.0.1'
);

# let's check if the call came from CLI
if ( php_sapi_name() === 'cli' ) {

    # iterate the consoles array
    foreach ($consoles as $console) {
        $app->add(new $console);
    }
}

$app->run();
```

Save the above code as ``console`` or any you want, while slayer is ``brood``.

Run it to your console:
```shell
php console
```
