<?php

namespace Oh\FOSFacebookUserBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SimpleFunctionTest extends WebTestCase {

  public function testIndex() {
    $client = static::createClient();

    $crawler = $client->request('GET', '/login');

    $this->assertEquals(1, $crawler->filter('html:contains("Remember me")')->count());
  }

}
