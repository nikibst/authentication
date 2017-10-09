<?php

namespace Bastas\Authentication;


class Authentication
{
    private $activeIdentity = null;
    private $config;

    public function __construct($config)
    {
        $activeIdentityClassName = $config['active_identity']['type'];
        $this->activeIdentity = new $activeIdentityClassName($config['active_identity']['store_key']);

        $this->config = $config;
    }

    public function authenticate($identity, $credential)
    {
        $credentialRepoClassName = $this->config['credentials_repository']['type'];
        $authAdapter = new $credentialRepoClassName($this->config['credentials_repository']);

        if ($authAdapter->authenticate($identity, $credential)) {
            $this->activeIdentity->assignActiveIdentity($authAdapter->getUniqueId());

            return true;
        }

        return false;
    }

    public function getActiveIdentity()
    {
        return $this->activeIdentity;
    }
}