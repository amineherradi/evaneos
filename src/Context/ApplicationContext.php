<?php

use Entity\Destination;
use Entity\Site;
use Entity\User;
use Faker\Factory;
use Helper\SingletonTrait;

class ApplicationContext
{
    use SingletonTrait;

    /**
     * @var Site $currentSite
     */
    private $currentSite;
    /**
     * @var User $currentUser
     */
    private $currentUser;
    /**
     * @var Destination $currentDestination
     */
    private $currentDestination;

    protected function __construct()
    {
        $faker = Factory::create();
        $this->currentSite = new Site($faker->randomNumber(), $faker->url);
        $this->currentUser = new User($faker->randomNumber(), $faker->firstName, $faker->lastName, $faker->email);
        $this->currentDestination = new Destination($faker->randomNumber(), $faker->country, "randomConjunction", "randomComputerName");
    }

    public function getCurrentSite()
    {
        return $this->currentSite;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    public function getCurrentDestination()
    {
        return $this->currentDestination;
    }
}
