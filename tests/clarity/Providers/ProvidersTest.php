<?php

namespace Clarity\Providers;

use Mockery as m;
use Clarity\Services\Container;

class ProvidersTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function sampleDiContent()
    {
        return [true, false, 123, '123ast'];
    }

    public function testService()
    {
        $provider = m::mock('Clarity\Providers\Aliaser');
        $provider
            ->shouldReceive(
                'register'
            )
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
        $container->addServiceProvider($provider);
        $container->boot();

        # assert should be instance of ServiceProvider::class

        $this->assertInstanceOf(ServiceProvider::class, $provider);

        # assert via array subset, in the first place, the di()
        # should already injected the 'servicetest' and it should
        # be pullable

        $this->assertArraySubset(
            di()->get('servicetest')->sampleDiContent(),
            $this->sampleDiContent()
        );
    }
}
