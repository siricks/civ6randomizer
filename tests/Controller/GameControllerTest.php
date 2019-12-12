<?php


namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class GameControllerTest extends BaseControllerTest
{
    /**
     * Test main - games
     */
    public function testShowGames()
    {
        $this->logIn();
        $this->client->request('GET', '/ru/games');

        $crawler = $this->client->followRedirect();

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Все игры', $crawler->filter('h1')->text());
    }





}
