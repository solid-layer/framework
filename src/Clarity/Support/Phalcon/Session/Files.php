<?php
namespace Clarity\Support\Phalcon\Session;

use Phalcon\Session\Adapter\Files as Adapter;

class Files extends Adapter
{
    /**
     * {@inheritdoc}
     */
    public function __construct($options)
    {
        parent::__construct($options);

        if (isset($options['session_storage']) === false) {
            $options['session_storage'] = url_trimmer(config()->path->storage.'/session');
        }

        session_save_path($options['session_storage']);

        session_set_cookie_params(
            $options['lifetime'],
            $options['path'],
            $options['domain'],
            $options['secure'],
            $options['httponly']
        );
    }
}
