<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:29 AM
 */

namespace App\Entity\Users;


interface Users
{
    public function add(User $user);
    public function delete(User $user);

    /**
     * @param string $login
     * @return User|null
     */
    public function findOneByLogin(string $login);
}