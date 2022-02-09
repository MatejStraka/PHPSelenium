<?php 

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Firefox\FirefoxDriver;

include_once 'DriverUtil.php';
include_once 'HomePage.php';
include_once 'LoginPopup.php';
include_once 'AccountPage.php';
include_once 'RegistrationPage.php';


final class RegistrationAndLoginTest extends TestCase
{
    protected $webDriver;
    protected $homePage;
    protected $loginPopup;  
    protected $registrationPage;  
    protected $accountPage;

    protected const DOMAIN = 'frontend-lux.test.emg.bootiq-preview.eu';
    protected const BROWSER = 'FIREFOX';
    protected const COOKIE_NAME = 'CookieConsent';
    protected const COOKIE_VALUE = '{stamp:%271XsjD0RCIyyUDxfy6Vhkt+ZVR/NP5N3PvqfIMqcIrOPNLUynTMXy3Q==%27%2Cnecessary:true%2Cpreferences:true%2Cstatistics:true%2Cmarketing:true%2Cver:1%2Cutc:1644330146255%2Cregion:%27cz%27}';

    /**
     * @beforeClass
     */
    public function setUp() : void
    {
        $this->webDriver = DriverUtil::getDriver(self::BROWSER);
        $this->homePage = new HomePage($this->webDriver);
        $this->loginPopup = new LoginPopup($this->webDriver);
        $this->registrationPage = new RegistrationPage($this->webDriver);
        $this->accountPage = new AccountPage($this->webDriver);

        $this->homePage->openURL('https://'.self::DOMAIN);
        $this->webDriver->manage()->addCookie(['name' =>self::COOKIE_NAME, 'value' => self::COOKIE_VALUE, 'domain' => self::DOMAIN]);
        $this->homePage->waitForAcceptedCookies();
        $this->homePage->waitForPageLoad();
        
    }


    /**
     * @dataProvider userProvider
     */
    public function testRegisterationAndLogin($firstName, $lastName, $email, $password, $confirmPassword) 
    {
        
        $this->homePage->openLoginPopup();
        $this->assertTrue($this->loginPopup->isLoginPopupDisplayed());
        $this->loginPopup->OpenRegistrationForm();
        $this->registrationPage->registerNewUser($firstName, $lastName, $email, $password, $confirmPassword);
        $this->assertEquals($email, $this->accountPage->getUserEmail());
        $this->accountPage->Logout();
        $this->assertTrue(strcmp($firstName.' '.$lastName, $this->homePage->getLoginText()) !==0 );
        $this->homePage->openLoginPopup();
        $this->assertTrue($this->loginPopup->isLoginPopupDisplayed());
        $this->loginPopup->loginUser($email, $password);
        $this->assertEquals($email, $this->accountPage->getUserEmail());
    }


    public function userProvider(): array
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $email = '';
        for ($i = 0; $i < 10; $i++) {
            $email .= $characters[rand(0, $charactersLength - 1)];
        }
        $email .= '@yopmail.com';

        return [['Test','Test', $email,'Test1234','Test1234']];        
    }

     /**
     * @afterClass
     */
    public function tearDown() : void
    {
        $this->webDriver->quit();
    }
}