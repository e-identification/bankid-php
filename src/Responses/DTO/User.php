<?php

namespace BankID\SDK\Responses\DTO;

/**
 * Class User
 *
 * @package BankID\SDK\Responses\DTO
 */
class User
{

    /**
     * The personal number.
     *
     * @var string
     */
    protected $personalNumber;

    /**
     * The given name and surname of the user.
     *
     * @var string
     */
    protected $name;

    /**
     * The given name of the user.
     *
     * @var string
     */
    protected $givenName;

    /**
     * The surname of the user.
     *
     * @var string
     */
    protected $surname;

    /**
     * @return string
     */
    public function getPersonalNumber(): string
    {
        return $this->personalNumber;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }
}
