<?php

namespace Bastas\Authentication\Adapter;

use Bastas\Authentication\AuthAdapterInterface;


class MySqlDbAdapter implements AuthAdapterInterface
{
    private $adapter;
    private $identityCol;
    private $credentialsCol;
    private $tableName;
    private $uniqueIdCol;
    private $uniqueId = null;

    public function __construct($config)
    {
        $this->adapter = $config['adapter'];
        $this->identityCol = $config['identityFieldName'];
        $this->credentialsCol = $config['credentialsFieldName'];
        $this->tableName = $config['entity']['table'];
        $this->uniqueIdCol = $config['entity']['uniqueId'];
    }

    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    public function authenticate($identity, $credential)
    {
        $sql = "SELECT `" . $this->uniqueIdCol . "`" .
            " FROM `"   . $this->tableName . "`" .
            " WHERE `"  . $this->identityCol . "` = :identity" .
            " AND `"    . $this->credentialsCol . "` = :credential";

        $preparedStatement = $this->adapter->prepare($sql);
        $preparedStatement->bindParam(':identity', $identity, \PDO::PARAM_STR);
        $preparedStatement->bindParam(':credential', $credential, \PDO::PARAM_STR);

        if($preparedStatement->execute()) {
            if($this->uniqueId = $preparedStatement->fetchColumn()) {
                return true;
            }
        }

        return false;
    }
}