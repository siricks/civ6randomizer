<?php


namespace App\Tests\Entity;


use App\Entity\Game;
use App\Entity\Leader;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    public function testSetGameDate()
    {
        $game = new Game();
        $dateTime = new \DateTimeImmutable();
        $game->setGameDate($dateTime);

        $this->assertEquals($dateTime, $game->getGameDate());
    }

    public function testSetLeader()
    {
        $game = new Game();
        $leader = new Leader();

        $game->setLeader($leader);

        $this->assertEquals($leader, $game->getLeader());
    }


}
