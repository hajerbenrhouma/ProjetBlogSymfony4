<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerVideoTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }

    public function testNoResults(){
        $client=  static::createClient();
        $client->followRedirect();
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Search video') ->form(['query' => 'aaa']);
        $crawler = $client->submit($form);
        $this ->assertContains('No Result were found', $crawler->filter('h1')->text());
    }

    public function TestResultFound(){
        $client=  static::createClient();
        $client->followRedirect();
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Search video') ->form(['query' => 'Movies']);
        $crawler = $client->submit($form);
        $this ->assertGreaterThan(4, $crawler->filter('h3')->count());
    }

    public function TestSorting(){
        $client=  static::createClient();
        $client->followRedirect();
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Search video') ->form(['query' => 'Movies']);
        $crawler = $client->submit($form);
        $form = $crawler->filter('#form-sorting') ->form(['sortby' => 'desc']);
        $this ->assertEquals('Movies 9', $crawler->filter('h3') ->first()->text());
    }
}
