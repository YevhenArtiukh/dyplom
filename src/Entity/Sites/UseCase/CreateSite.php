<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 11:13 AM
 */

namespace App\Entity\Sites\UseCase;


use App\Core\Transaction;
use App\Entity\Sites\Site;
use App\Entity\Sites\Sites;
use App\Entity\Sites\UseCase\CreateSite\Command;

class CreateSite
{
    private $sites;
    private $transaction;

    public function __construct(
        Sites $sites,
        Transaction $transaction
    )
    {
        $this->sites = $sites;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $site = new Site(
            $command->getUrl(),
            $command->getUrlType(),
            $command->getLocalStorage(),
            $command->getSessionStorage(),
            $command->getCookie(),
            $command->getUser()
        );

        $this->sites->add($site);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }
}