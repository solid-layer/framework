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
namespace Clarity\Console\Server;

use Clarity\Console\Brood;

/**
 * A console command that determines the current environment.
 */
class EnvCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'env';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Get current environment';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $timeout = $this->getInput()->getOption('timeout');

        $this->info(
            "\n".'Your current environment ['.config()->environment.']'."\n"
            // .' | Timeout: '.$timeout
        );
    }
}
