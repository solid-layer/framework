<?php

namespace Clarity\Console\Queue;

use Exception;
use Clarity\Facades\Queue;
use Clarity\Console\Brood;

class Listen extends Brood
{
    protected $name = 'queue:listen';
    protected $description = 'Listen to pushed queues';

    protected function processJob($job)
    {
        $data = $job->getBody();

        if (!isset($data['class'])) {
            return false;
        }

        $exclass = explode('@', $data['class']);

        $method = 'listener';

        if (isset($exclass[1])) {
            $method = $exclass[1];
        }

        (new $exclass[0])->{$method}($this, $job, $body['data']);

        return true;
    }

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
