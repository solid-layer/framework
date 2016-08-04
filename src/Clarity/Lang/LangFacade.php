<?php
/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

/**
 */
namespace Clarity\Lang;

use Clarity\Facades\Facade;

class LangFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lang';
    }
}
