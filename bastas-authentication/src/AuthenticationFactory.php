<?php

namespace Bastas\Authentication;

use Bastas\Authentication\Exception\AuthenticationException;


class AuthenticationFactory
{
    private $authentication = null;

    public function __construct($config)
    {
        if(!isset($config['authentication']['credentials_repository'])) {
            throw new AuthenticationException('"credentials_repository" settings are missing');
        }

        if(!isset($config['authentication']['credentials_repository']['type'])) {
            throw new AuthenticationException('"credentials_repository" --> "identityFieldName" key is missing');
        }

        if(!isset($config['authentication']['credentials_repository']['identityFieldName'])) {
            throw new AuthenticationException('"credentials_repository" --> "identityFieldName" key is missing');
        }

        if(!isset($config['authentication']['credentials_repository']['credentialsFieldName'])) {
            throw new AuthenticationException('"credentials_repository" --> "credentialsFieldName" key is missing');
        }

        if(!isset($config['authentication']['credentials_repository']['entity'])) {
            throw new AuthenticationException('"credentials_repository" --> "entity" key is missing');
        }


        switch ($config['authentication']['credentials_repository']['type']) {
            case 'MySqlDbAdapter':
                $this->authentication = new Authentication($config['authentication']);
                break;
        }
    }

    public function getInstance()
    {
        return $this->authentication;
    }
}