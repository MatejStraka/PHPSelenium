<?php

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Firefox\FirefoxDriver;

class AccountPage{

    private $userAccountButton;
    private $innerMenuButtons;
    private $userEmailText;
    private $driver;


    public function __construct($driver){
        $this->driver = $driver;
        $this->userAccountButton = WebDriverBy::cssSelector('a[href="/account/profile"]');
        $this->innerMenuButtons = WebDriverBy::cssSelector('.ant-popover-content button');
        $this->userEmailText = WebDriverBy::cssSelector('.ant-popover-inner-content>div>div:first-of-type');
    }

    public function getUserName(){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::presenceOfElementLocated($this->userAccountButton));
        return $this->driver->findElement($this->userAccountButton)->getText();
    }

    public function Logout(){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::presenceOfElementLocated($this->userAccountButton));
        $action = $this->driver->action();
        $action->moveToElement($this->driver->findElement($this->userAccountButton))->perform();
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::visibilityOfElementLocated($this->innerMenuButtons));
        $this->driver->findElements($this->innerMenuButtons)[4]->click();
    }

    public function getUserEmail(){
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::presenceOfElementLocated($this->userAccountButton));
        $action = $this->driver->action();
        $action->moveToElement($this->driver->findElement($this->userAccountButton))->perform();
        $this->driver->wait(10, 1000)->until( WebDriverExpectedCondition::visibilityOfElementLocated($this->userEmailText));
        return $this->driver->findElement($this->userEmailText)->getText();
    }
}
?>