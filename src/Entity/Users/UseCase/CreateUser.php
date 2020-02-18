<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:56 AM
 */

namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\CreateUser\Command;
use App\Entity\Users\User;
use App\Entity\Users\Users;

class CreateUser
{
    private $users;
    private $transaction;

    public function __construct(
        Users $users,
        Transaction $transaction
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingLogin = $this->users->findOneByLogin($command->getLogin());

        if($existingLogin)
            return;

        $user = new User(
            $command->getLogin(),
            $command->getPassword(),
            $command->getEmail()
        );

        $this->users->add($user);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}