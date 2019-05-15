<?php

namespace Repository;

use Entity\Destination;
use Faker\Factory;
use RepositoryInterface\Repository;
use Helper\SingletonTrait;

class DestinationRepository implements Repository
{
    use SingletonTrait;

    private $country;
    private $conjunction;
    private $computerName;

    /**
     * DestinationRepository constructor.
     */
    public function __construct()
    {
        $this->country = Factory::create()->country;
        $this->conjunction = 'en';
        $this->computerName = Factory::create()->slug();
    }

    /**
     * @param int $id
     *
     * @return Destination
     */
    public function getById($id)
    {
        // DO NOT MODIFY THIS METHOD
        return new Destination(
            $id,
            $this->country,
            $this->conjunction,
            $this->computerName
        );
    }
}
