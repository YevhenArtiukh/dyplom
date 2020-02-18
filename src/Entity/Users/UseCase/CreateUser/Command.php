<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:56 AM
 */

namespace App\Entity\Users\UseCase\CreateUser;


class Command
{
    private $login;
    private $password;
    private $email;
    private $responder;

    public function __construct(
        string $login,
        string $password,
        string $email
    )
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->responder = new NullResponder();
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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