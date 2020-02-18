<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:30 AM
 */

namespace App\Core;


interface Transaction
{
    public function begin();
    public function commit();
    public function rollback();
}