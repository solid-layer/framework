<?php
namespace Slayer\Acceptance;

use Components\Model\User;
use Clarity\TestSuite\Behat\Mink\Mink;

/*
+------------------------------------------------------------------------------+
|\ ONCE UPON A TIME:                                                          /|
+------------------------------------------------------------------------------+
| I want to visit 'http://slayer.app'
| this is my first visit, so I must see the font logo which is 'Slayer'
| then upon clicking the 'Try sample forms' link
| I should be redirected to 'http://slayer.app/auth/registration'
| I have option to register an account
| Upon register, I should activate my account
| I should go back to the main welcome page
| Then click again the 'Try sample forms'
| I should be redirected to 'http://slayer.app/auth/login'
| I have an option to log-in using the registered account
+-------------------------------------------------------------------------------
*/
class AppTest extends \PHPUnit_Framework_TestCase
{
    private $session;
    private $url;
    private $email;
    private $password;

    public function setUp()
    {
        $this->session = (new Mink)->get('goutte');
        $this->url = 'http://localhost:8080';
        $this->email = 'test@example.com';
        $this->password = '123qwe';
    }

    private function triggerWelcomeProcess()
    {
        $this->session->visit($this->url);

        $this->assertEquals("200", $this->session->getStatusCode()); // === 200
        $this->assertContains($this->url, $this->session->getCurrentUrl()); // === $this->url

        $welcome_page = $this->session->getPage();

        $slayer_logo = $welcome_page->find(
            'named',
            ['id', 'frameworkTitle']
        );

        $this->assertContains("Slayer", $slayer_logo->getHtml()); // === "Slayer"

        $try_sample_forms = $welcome_page->find('xpath', '//a[@href="'.$this->url.'/try-sample-forms"]');
        $try_sample_forms->click();
    }

    public function testRegistration()
    {
        if ( User::count() ) {
            $this->testLogin();
            return;
        }

        $this->triggerWelcomeProcess();

        # REGISTRATION
        $this->assertEquals("200", $this->session->getStatusCode()); // === 200
        $this->assertContains($this->url.'/auth/register', $this->session->getCurrentUrl()); // === $this->url.'auth/register'

        $register_page = $this->session->getPage();

        $register_btn = $register_page->find(
            'named',
            ['id', 'register-btn']
        );

        $register_page->fillField('email', $this->email);
        $register_page->fillField('password', $this->password);
        $register_page->fillField('repassword', $this->password);
        $register_btn->click();

        $user = User::query()->where('email = :email: AND activated = :activated:')
            ->bind([
                'email' => $this->email,
                'activated' => (int) false,
            ])
            ->execute()
            ->getFirst();

        var_dump($user->toArray());

        $this->session->visit($this->url.'/auth/activation/'.$user->token);
    }

    public function testLogin()
    {
        if ( !User::count() ) {
            $this->testRegistration();
        }

        $this->triggerWelcomeProcess();

        # LOGIN
        $this->assertEquals("200", $this->session->getStatusCode()); // === 200
        $this->assertContains($this->url.'/auth/login', $this->session->getCurrentUrl()); // === $this->url.'auth/register'

        $login_page = $this->session->getPage();

        $login_btn = $login_page->find(
            'named',
            ['id', 'login-btn']
        );

        $login_page->fillField('email', $this->email);
        $login_page->fillField('password', $this->password);
        $login_btn->click();

        $this->assertContains($this->url.'/newsfeed', $this->session->getCurrentUrl()); // === $this->url.'newsfeed'
    }

}
