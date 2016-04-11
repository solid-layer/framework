<?php
/**
 * PhalconSlayer\Framework
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phalconslayer.readme.io
 */

/**
 * @package Clarity
 * @subpackage Clarity\Providers
 */
namespace Clarity\Providers;

use Clarity\Support\Phalcon\Mvc\URL as BaseURL;

class URL extends ServiceProvider
{
    protected $alias = 'url';
    protected $shared = false;
    protected $after_module = true;

    public function register()
    {
        return BaseURL::getInstance();
    }
}
