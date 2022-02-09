<?php

use \Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Firefox\FirefoxDriver;

class LoginPopup{

    private $registerButton;
    private $firstNameInput;
    private $lastNameInput;
    private $emailInput;
    private $passwordInput;
    private $confirmPasswordInput;
    private $popupHeadline;
    private $driver;


    public function __construct($driver){
        $this->driver = $driver;
        $this->registerButton = WebDriverBy::id('gotoRegistrationButton');
        $this->loginButton = WebDriverBy::id('loginButton');
        $this->emailInput = WebDriverBy::id('loginEmail');
        $this->passwordInput = WebDriverBy::id('loginPassword');
    }

    public function OpenRegistrationForm(){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::elementToBeClickable($this->loginButton));
        $this->driver->findElements($this->registerButton)[1]->click();
    }

    public function Login(){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::elementToBeClickable($this->loginButton));
        $this->driver->findElement($this->loginButton)->click();
    }

    public function enterEmail($email){
        $this->driver->findElement($this->emailInput)->sendKeys(WebDriverKeys::BACKSPACE);
        $this->driver->findElement($this->emailInput)->sendKeys($email);
    }

    public function enterPassword($password){
        $this->driver->findElement($this->passwordInput)->sendKeys($password);
    }

    public function isLoginPopupDisplayed(){
        $this->driver->wait(10, 1000)->until(WebDriverExpectedCondition::visibilityOfElementLocated($this->loginButton));
        return $this->driver->findElement($this->loginButton)->isDisplayed();
    }

    public function loginUser($email, $password){
        $this->enterEmail($email);
        $this->enterPassword($password);
        $this->Login();
    }

}

?>