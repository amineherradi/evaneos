<?php

namespace Repository;

use Entity\User;
use Faker\Factory;
use Helper\SingletonTrait;
use RepositoryInterface\Repository;

class UserRepository implements Repository
{
    use SingletonTrait;

    private $firstname;
    private $lastname;
    private $email;

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $generator = Factory::create();

        $this->firstname = $generator->firstName;
        $this->lastname  = $generator->lastName;
        $this->email     = $generator->email;
    }

    /**
     * @param $id
     * @return User
     */
    public function getById($id)
    {
        return new User(
            $id,
            $this->firstname,
            $this->lastname,
            $this->email
        );
    }
}