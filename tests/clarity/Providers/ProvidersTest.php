<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Providers;

use Mockery as m;
use Clarity\Services\Container;

/**
 * The 'providers' test case.
 */
class ProvidersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * A sample dependency response.
     *
     * @return array
     */
    public function sampleDiContent()
    {
        return [true, false, 123, '123ast'];
    }

    /**
     * Test for service providers.
     *
     * @return void
     */
    public function testService()
    {
        $provider = m::mock('Clarity\Providers\Aliaser');

        $provider
            ->shouldReceive('register')
            ->once()
            ->andReturn($this);

        $provider
            ->shouldReceive('getAlias')
            ->once()
            ->andReturn('servicetest');

        $provider
            ->shouldReceive('callRegister')
            ->once()
            ->andReturn($provider->register());

        $provider
            ->shouldReceive('getShared')
            ->once()
            ->andReturn(true);

        $provider
            ->shouldReceive('boot')
            ->once();

        $container = new Container;
        $container->setDI(di());
        $container->addServiceProvider($provider);
        $container->boot();


        # assert should be instance of ServiceProvider::class
        $this->assertInstanceOf(ServiceProvider::class, $provider);


        # assert via array subset, in the first place, the di()
        # should already injected the 'servicetest' and it should
        # be pullable
        $this->assertArraySubset(
            $container->getDI()->get('servicetest')->sampleDiContent(),
            $this->sampleDiContent()
        );
    }
}
