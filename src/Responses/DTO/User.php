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
     * Returns the personal number.
     *
     * @return string
     */
    public function getPersonalNumber(): string
    {
        return $this->personalNumber;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the given name.
     *
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * Returns the surname.
     *
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }
}
