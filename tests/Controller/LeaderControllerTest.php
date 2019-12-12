<?php


namespace App\Tests\Controller;


use Symfony\Component\HttpFoundation\Response;

class LeaderControllerTest extends BaseControllerTest
{
    /**
     * Test main - leader
     */
    public function testShowLeaders()
    {
        $this->logIn();
        $this->client->request('GET', '/ru/leader');

        $crawler = $this->client->followRedirect();

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Все лидеры', $crawler->filter('h1')->text());

        //31 card with leaders in page
        $this->assertCount(
            31,
            $crawler->filter('.card')
        );
    }

    /**
     * Test random leader
     */
    public function testGetRandomLeaders()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/ru/leader/get_random');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Случайный лидер', $crawler->filter('h1')->text());

        //4 card with leaders in page
        $this->assertCount(
            4,
            $crawler->filter('.card')
        );
    }
}
