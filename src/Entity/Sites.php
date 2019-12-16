<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SitesRepository")
 */
class Sites
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $urlType;

    /**
     * @ORM\Column(type="integer")
     */
    private $localStorage;

    /**
     * @ORM\Column(type="integer")
     */
    private $sessionStorage;

    /**
     * @ORM\Column(type="integer")
     */
    private $cookie;

    /**
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * Sites constructor.
     * @param $url
     * @param $urlType
     * @param $localStorage
     * @param $sessionStorage
     * @param $cookie
     * @param $user
     */
    public function __construct(
        string $url,
        string $urlType,
        int $localStorage,
        int $sessionStorage,
        int $cookie,
        ?Users $user)
    {
        $this->url = $url;
        $this->urlType = $urlType;
        $this->localStorage = $localStorage;
        $this->sessionStorage = $sessionStorage;
        $this->cookie = $cookie;
        $this->user = $user;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrlType(): ?string
    {
        return $this->urlType;
    }

    public function setUrlType($urlType): self
    {
        $this->urlType = $urlType;

        return $this;
    }

    public function getLocalStorage(): ?int
    {
        return $this->localStorage;
    }

    public function setLocalStorage($localStorage): self
    {
        $this->localStorage = $localStorage;

        return $this;
    }

    public function getSessionStorage(): ?int
    {
        return $this->sessionStorage;
    }

    public function setSessionStorage($sessionStorage): self
    {
        $this->sessionStorage = $sessionStorage;

        return $this;
    }

    public function getCookie(): ?int
    {
        return $this->cookie;
    }

    public function setCookie($cookie): self
    {
        $this->cookie = $cookie;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
