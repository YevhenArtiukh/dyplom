<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:34 AM
 */

namespace App\Entity\Sites;


interface Sites
{
    public function add(Site $site);
    public function delete(Site $site);

    /**
     * @return mixed
     */
    public function findPolitic();

    /**
     * @return mixed
     */
    public function findShop();

    /**
     * @return mixed
     */
    public function findBlog();

    /**
     * @return mixed
     */
    public function findEntertaining();

    /**
     * @return mixed
     */
    public function findOther();

    /**
     * @return int
     */
    public function findCountLocalStorage();

    /**
     * @return int
     */
    public function findCountSessionStorage();

    /**
     * @return int
     */
    public function findCountCookie();

    /**
     * @return mixed
     */
    public function findAll();
}