<?php

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Firefox\FirefoxDriver;

class HomePage{

    private $loginButton;
    private $userAccountLink;
    private $cookieCircle;
    private $driver;


    public function __construct($driver){
        $this->driver = $driver;
        $this->loginButton = WebDriverBy::id('user-account');
        $this->userAccountLink = WebDriverBy::cssSelector('a[href="/account/profile"]');
        $this->cookieCircle = WebDriverBy::id('CookiebotWidget');
    }

    public function openLoginPopup(){      
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::elementToBeClickable($this->loginButton));
        $this->driver->findElement($this->loginButton)->click();       
    }

    public function waitForAcceptedCookies(){
        $this->driver->wait()->until(WebDriverExpectedCondition::refreshed(WebDriverExpectedCondition::presenceOfElementLocated($this->cookieCircle)));
    }

    public function goToUserAccount(){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::visibilityOfElementLocated($this->userAccountLink));
        return $this->driver->findElement($this->userAccountLink)->click();
    }

    public function getLoginText(){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::invisibilityOfElementLocated($this->userAccountLink));
        return $this->driver->findElement($this->loginButton)->getText();
    }

    public function openURL($url){
        $this->driver->get($url);
    }

    public function waitForPageLoad(){
        $driver=$this->driver;
        $this->driver->wait()->until(
            function () use ($driver) {
                return strcmp($driver->executeScript('return document.readyState'),'complete') == 0;
            },
            'Page not fully loaded'
        );
    }
}
?>