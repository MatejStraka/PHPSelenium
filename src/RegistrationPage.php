<?php

use \Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Firefox\FirefoxDriver;

class RegistrationPage {

    private $registerButton;
    private $firstNameInput;
    private $lastNameInput;
    private $emailInput;
    private $passwordInput;
    private $confirmPasswordInput;
    private $driver;


    public function __construct($driver){
        $this->driver = $driver;
        $this->registerButton = WebDriverBy::cssSelector('#mainContent button');
        $this->firstNameInput = WebDriverBy::id('first_name');
        $this->lastNameInput = WebDriverBy::id('last_name');
        $this->emailInput = WebDriverBy::id('registerEmail');
        $this->passwordInput = WebDriverBy::id('registerPassword');
        $this->confirmPasswordInput = WebDriverBy::id('registerPasswordConfirm');
    }

    public function Register(){
        $this->driver->executeScript('window.scrollBy(0,300);');
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::elementToBeClickable($this->registerButton));
        $this->driver->findElement($this->registerButton)->click();
    }

    public function enterFirstName($firstName){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::elementToBeClickable($this->firstNameInput));
        $this->driver->findElement($this->firstNameInput)->sendKeys($firstName);
    }
    public function enterLastName($lastName){
        $this->driver->findElement($this->lastNameInput)->sendKeys($lastName);
    }
    public function enterEmail($email){
        $this->driver->findElement($this->emailInput)->sendKeys(WebDriverKeys::BACKSPACE);
        $this->driver->findElement($this->emailInput)->sendKeys($email);
    }
    public function enterPassword($password){
        $this->driver->findElement($this->passwordInput)->sendKeys($password);
    }
    public function enterConfirmPassword($confirmPassword){
        $this->driver->findElement($this->confirmPasswordInput)->sendKeys($confirmPassword);
    }

    public function registerNewUser($firstName, $lastName, $email, $password, $confirmPassword){
        $this->enterFirstName($firstName);
        $this->enterLastName($lastName);
        $this->enterEmail($email);
        $this->enterPassword($password);
        $this->enterConfirmPassword($confirmPassword);
        $this->Register();
    }

}

?>