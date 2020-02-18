<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:35 AM
 */

namespace App\Adapter\Users;

use App\Entity\Users\User;
use App\Entity\Users\Users as UsersInterface;
use Doctrine\ORM\EntityManager;

class Users implements UsersInterface
{
    private $manager;

    public function __construct(
        EntityManager $manager
    )
    {
        $this->manager = $manager;
    }

    public function add(User $user)
    {
        $this->manager->persist($user);
    }

    public function delete(User $user)
    {
        $this->manager->remove($user);
    }

    /**
     * @param string $login
     * @return User|null
     */
    public function findOneByLogin(string $login)
    {
        return $this->manager->getRepository(User::class)->findOneBy([
            'login' => $login
        ]);
    }
}