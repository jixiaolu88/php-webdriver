<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

// An example of using php-webdriver.
// Do not forget to run composer install before and also have Selenium server started and listening on port 4444.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

// start Chrome with 5 second timeout
$host = 'http://localhost:8555/wd/hub'; // this is the default
$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($host, $capabilities, 5000);

// navigate to 'http://www.seleniumhq.org/'
$driver->get('https://www.seleniumhq.org/');

// adding cookie
$driver->manage()->deleteAllCookies();

$cookie = new Cookie('cookie_name', 'cookie_value');
$driver->manage()->addCookie($cookie);

$cookies = $driver->manage()->getCookies();
print_r($cookies);

// click the link 'About'
$link = $driver->findElement(
    WebDriverBy::id('menu_about')
);
$link->click();

// wait until the page is loaded
$driver->wait()->until(
    WebDriverExpectedCondition::titleContains('About')
);

// print the title of the current page
echo "The title is '" . $driver->getTitle() . "'\n";

// print the URI of the current page
echo "The current URI is '" . $driver->getCurrentURL() . "'\n";

// write 'php' in the search box
$driver->findElement(WebDriverBy::id('q'))
    ->sendKeys('php') // fill the search box
    ->submit(); // submit the whole form

// wait at most 10 seconds until at least one result is shown
$driver->wait(10)->until(
    WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
        WebDriverBy::className('gsc-result')
    )
);

// close the browser
$driver->quit();
