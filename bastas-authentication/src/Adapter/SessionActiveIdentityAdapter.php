<?php

namespace Bastas\Authentication\Adapter;

use Bastas\Authentication\ActiveIdentityInterface;
use Bastas\Authentication\Exception\ActiveIdentityAuthException;


class SessionActiveIdentityAdapter implements ActiveIdentityInterface
{
    private $storeKey;

    public function __construct($storeKey)
    {
        if(!isset($_SESSION)) {
            throw new ActiveIdentityAuthException("Session has not been initialized.");
        }

        $this->storeKey = $storeKey;
    }

    public function hasUniqueId()
    {
        return isset($_SESSION[$this->storeKey]);
    }

    public function getUniqueId()
    {
        if(isset($_SESSION[$this->storeKey])) {
            return $_SESSION[$this->storeKey];
        }

        return '';
    }

    public function assignUniqueId($uniqueId)
    {
        $_SESSION[$this->storeKey] = $uniqueId;
    }

    public function deleteUniqueId()
    {
        unset($_SESSION[$this->storeKey]);
    }
}