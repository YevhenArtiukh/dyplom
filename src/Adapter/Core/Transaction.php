<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:30 AM
 */

namespace App\Adapter\Core;

use App\Core\Transaction as TransactionInterface;
use Doctrine\ORM\EntityManager;

final class Transaction implements TransactionInterface
{
    private $manager;

    public function __construct(
        EntityManager $manager
    )
    {
        $this->manager = $manager;
    }

    public function begin()
    {
        $this->manager->beginTransaction();
    }

    public function commit()
    {
        $this->manager->commit();
        $this->manager->flush();
    }

    public function rollback()
    {
        $this->manager->rollback();
    }
}