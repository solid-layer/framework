<?php

use Clarity\Lang\Lang;

class TranslationTest extends \Codeception\Test\Unit
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

    protected function getLangInstance()
    {
        $translation = new Lang();
        $translation
            ->setLanguage(config('app.lang', 'en'))
            ->setLangDir(__DIR__.'/resources/lang');

        return $translation;
    }

    public function testTranslationInstance()
    {
        $instance = $this->getLangInstance();

        $this->assertInstanceOf(Lang::class, $instance);
    }

    /**
     * Assert common response.
     */
    protected function assertResponse($resp)
    {
        $this->assertEquals($resp, 'Welcome Human to S.layer');
    }

    /**
     * Test the root file translation.
     *
     * @return void
     */
    public function testRootFileTranslation()
    {
        $instance = $this->getLangInstance();


        # calling the simpliest translation
        $resp = $instance->get('simple.motd');
        $this->assertResponse($resp);


        # using {name} | {project} params
        $resp = $instance->get('simple.motd_with_params', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);


        # using :name | :project params
        $resp = $instance->get('simple.motd_with_params_2', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);


        # ARRAY


        # calling the simpliest translation
        $resp = $instance->get('simple.array.motd');
        $this->assertResponse($resp);


        # using {name} | {project} params
        $resp = $instance->get('simple.array.motd_with_params', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);


        # using :name | :project params
        $resp = $instance->get('simple.array.motd_with_params_2', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);
    }

    /**
     * Test the file from a folder translation.
     *
     * @return void
     */
    public function testFolderFileTranslation()
    {
        $instance = $this->getLangInstance();


        # calling the simpliest translation
        $resp = $instance->get('folder/site.motd');
        $this->assertResponse($resp);


        # using {name} | {project} params
        $resp = $instance->get('folder/site.motd_with_params', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);


        # using :name | :project params
        $resp = $instance->get('folder/site.motd_with_params_2', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);


        # ARRAY


        # calling the simpliest translation
        $resp = $instance->get('folder/site.array.motd');
        $this->assertResponse($resp);


        # using {name} | {project} params
        $resp = $instance->get('folder/site.array.motd_with_params', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);


        # using :name | :project params
        $resp = $instance->get('folder/site.array.motd_with_params_2', [
            'name' => 'Human',
            'project' => 'S.layer',
        ]);
        $this->assertResponse($resp);
    }
}
