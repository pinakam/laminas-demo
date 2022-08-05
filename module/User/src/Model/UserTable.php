<?php

namespace User\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class UserTable
{
    /**
     * @var TableGatewayInterface
     */
    private TableGatewayInterface $tableGateway;

    /**
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return \Laminas\Db\ResultSet\ResultSetInterface
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchUser($id)
    {
        $id = (int) $id;

        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    /**
     * @param $user
     * @return void
     */
    public function saveUser($user)
    {
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
        ];

        $userId = $user->id;

        if ($userId === 0) {
            $this->tableGateway->insert($userData);
            return;
        }

        try {
            $this->fetchUser($userId);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf("Can not update user for the given id %d", $userId));
        }

        $this->tableGateway->update($userData, ['id' => $userId]);
    }

    /**
     * @param $userId
     * @return void
     */
    public function deleteUser($userId)
    {
        $this->tableGateway->delete(['id' => $userId]);
    }
}