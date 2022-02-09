<?php

putenv('WEBDRIVER_CHROME_DRIVER=C:\Users\mstra\Downloads\chromedriver_win32\chromedriver.exe');
putenv('WEBDRIVER_FIREFOX_DRIVER=C:\Users\mstra\Downloads\geckodriver-v0.30.0-win64\geckodriver.exe');
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Firefox\FirefoxDriver;

class DriverUtil
{
    static $desired_capabilities;

    public static function getDriver($browser)
    {
        switch (strtoupper($browser)) {
            case 'FIREFOX':
                $firefoxOptions = new FirefoxOptions();
                $firefoxOptions->addArguments(['start-maximized']);
                self::$desired_capabilities = DesiredCapabilities::firefox();
                self::$desired_capabilities->setCapability(FirefoxOptions::CAPABILITY, $firefoxOptions);
                return FirefoxDriver::start(self::$desired_capabilities);
            default:
                $chromeOptions = new ChromeOptions();
                $chromeOptions->addArguments(['start-maximized']);
                self::$desired_capabilities = DesiredCapabilities::chrome();
                self::$desired_capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);
                return ChromeDriver::start(self::$desired_capabilities);
        } 
    }
}