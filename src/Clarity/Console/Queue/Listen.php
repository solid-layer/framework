<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Console\Queue;

use Exception;
use Clarity\Facades\Queue;
use Clarity\Console\Brood;

/**
 * Listen to a queue.
 */
class Listen extends Brood
{
    /**
     * @var string
     */
    protected $name = 'queue:listen';

    /**
     * @var string
     */
    protected $description = 'Listen to pushed queues';

    /**
     * Process a certain job.
     *
     * @param $job \Phalcon\Queue\Beanstalk\Job
     * @return bool
     */
    protected function processJob($job)
    {
        $body = $job->getBody();

        if (! isset($body['class'])) {
            return false;
        }

        $exclass = explode('@', $body['class']);

        $method = 'listener';

        if (isset($exclass[1])) {
            $method = $exclass[1];
        }

        (new $exclass[0])->{$method}($this, $job, $body['data']);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        while (true) {
            try {
                while (($job = Queue::peekReady()) !== false) {
                    $this->processJob($job);
                }
            } catch (Exception $e) {
                $this->exception($e);
            }
        }
    }
}
