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

use Illuminate\Support\Str;
use Phalcon\Crypt as BaseCrypt;

class Crypt extends ServiceProvider
{
    protected $alias = 'crypt';
    protected $shared = true;

    public function register()
    {
        $crypt = new BaseCrypt();

        if (Str::startsWith($key = config('app.encryption.key'), 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $crypt->setKey($key);
        $crypt->setCipher(config('app.encryption.cipher'));
        $crypt->setMode(config('app.encryption.mode'));

        return $crypt;
    }
}
