<?php

namespace User;

use Closure;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use User\Controller\UserController;
use User\Model\User;
use User\Model\UserTable;

class Module implements ConfigProviderInterface
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return Closure[][]
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                UserController::class => function ($container) {
                    return new UserController($container->get(UserTable::class));
                }
            ],
        ];
    }

    /**
     * @return Closure[][]
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                UserTable::class => function ($container) {
                    $tableGateway = $container->get(Model\UserTableGateway::class);

                    return new UserTable($tableGateway);
                },
                Model\UserTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);

                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->getArrayObjectPrototype(new User());

                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                }
            ],

        ];
    }
}