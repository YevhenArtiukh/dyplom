<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:35 AM
 */

namespace App\Adapter\Sites;

use App\Entity\Sites\Site;
use App\Entity\Sites\Sites as SitesInterface;
use Doctrine\ORM\EntityManager;

class Sites implements SitesInterface
{
    private $manager;

    public function __construct(
        EntityManager $manager
    )
    {
        $this->manager = $manager;
    }

    public function add(Site $site)
    {
        $this->manager->persist($site);
    }

    public function delete(Site $site)
    {
        $this->manager->remove($site);
    }

    /**
     * @return mixed
     */
    public function findPolitic()
    {
        return $this->manager->getRepository(Site::class)->findBy([
            'urlType' => 'politic'
        ]);
    }

    /**
     * @return mixed
     */
    public function findShop()
    {
        return $this->manager->getRepository(Site::class)->findBy([
            'urlType' => 'shop'
        ]);
    }

    /**
     * @return mixed
     */
    public function findBlog()
    {
        return $this->manager->getRepository(Site::class)->findBy([
            'urlType' => 'blog'
        ]);
    }

    /**
     * @return mixed
     */
    public function findEntertaining()
    {
        return $this->manager->getRepository(Site::class)->findBy([
            'urlType' => 'entertaining'
        ]);
    }

    /**
     * @return mixed
     */
    public function findOther()
    {
        return $this->manager->getRepository(Site::class)->findBy([
            'urlType' => 'other'
        ]);
    }

    /**
     * @return int
     */
    public function findCountLocalStorage()
    {
        return $this->manager->getRepository(Site::class)->findAllLocalStorage();
    }

    /**
     * @return int
     */
    public function findCountSessionStorage()
    {
        return $this->manager->getRepository(Site::class)->findAllSessionStorage();
    }

    /**
     * @return int
     */
    public function findCountCookie()
    {
        return $this->manager->getRepository(Site::class)->findAllCookie();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->manager->getRepository(Site::class)->findAll();
    }
}