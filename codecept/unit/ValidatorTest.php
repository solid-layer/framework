<?php

use Clarity\Util\Validator\Validator;
use Clarity\Util\Validator\Tests\Sample;

class ValidatorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidator()
    {
        $validator = new Validator;

        $sample = new Sample;

        $validation = $validator->make(
            $sample->validationData(),
            $sample->rules()
        );

        if ($validation->fails()) {
            dd($validation->errors());
        }

        # there should be no error at all...
        $this->assertFalse($validation->fails());
    }
}
