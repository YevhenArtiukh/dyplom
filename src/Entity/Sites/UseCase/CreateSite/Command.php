<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 11:13 AM
 */

namespace App\Entity\Sites\UseCase\CreateSite;


use App\Entity\Users\User;

class Command
{
    private $url;
    private $urlType;
    private $localStorage;
    private $sessionStorage;
    private $cookie;
    private $user;
    private $responder;

    public function __construct(
        string $url,
        string $urlType,
        int $localStorage,
        int $sessionStorage,
        int $cookie,
        ?User $user
    )
    {
        $this->url = $url;
        $this->urlType = $urlType;
        $this->localStorage = $localStorage;
        $this->sessionStorage = $sessionStorage;
        $this->cookie = $cookie;
        $this->user = $user;
        $this->responder = new NullResponder();
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getUrlType(): string
    {
        return $this->urlType;
    }

    /**
     * @return int
     */
    public function getLocalStorage(): int
    {
        return $this->localStorage;
    }

    /**
     * @return int
     */
    public function getSessionStorage(): int
    {
        return $this->sessionStorage;
    }

    /**
     * @return int
     */
    public function getCookie(): int
    {
        return $this->cookie;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getResponder(): Responder
    {
        return $this->responder;
    }

    public function setResponder(Responder $responder): self
    {
        $this->responder = $responder;

        return $this;
    }
}