<?php

namespace User\Controller;

use Exception;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use User\Form\UserForm;
use User\Model\User;
use User\Model\UserTable;

class UserController extends AbstractActionController
{
    /**
     * @var UserTable
     */
    private UserTable $userTable;

    /**
     * @param UserTable $userTable
     */
    public function __construct(UserTable $userTable)
    {
        $this->userTable = $userTable;
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $users = $this->userTable->fetchAll();

        return new ViewModel(compact('users'));
    }

    /**
     * @return Response|UserForm[]
     */
    public function addUserAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Add User');
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());

        $this->userTable->saveUser($user);
        return $this->redirect()->toRoute('users');
    }

    /**
     * @return array|Response
     */
    public function editUserAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('users', ['action' => 'add-user']);
        }

        try {
            $user = $this->userTable->fetchUser($id);
        } catch (Exception $e) {
            return $this->redirect()->toRoute('users', ['action' => 'index']);
        }

        $userForm = new UserForm();
        $userForm->bind($user);

        $userForm->get('submit')->setAttribute('value', 'Edit User');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $userForm];

        if (!$request->isPost()) {
            return $viewData;
        }

        $temp = new User();
        $userForm->setInputFilter($temp->getInputFilter());
        $userForm->setData($request->getPost());

        if (!$userForm->isValid()) {
            return $viewData;
        }

        $this->userTable->saveUser($user);

        return $this->redirect()->toRoute('users', ['action' => 'index']);
    }

    /**
     * @return Response
     */
    public function deleteUserAction()
    {
        $id = $this->params()->fromRoute('id', 0);

        $this->userTable->deleteUser($id);

        return $this->redirect()->toRoute('users', ['action' => 'index']);
    }
}