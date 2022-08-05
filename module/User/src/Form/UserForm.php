<?php

namespace User\Form;

use Laminas\Form\Form;

class UserForm extends Form
{
    public function __construct()
    {
        parent::__construct('users');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Name'
            ]
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'Email'
            ]
        ]);

        $this->add([
            'name' => 'mobile',
            'type' => 'text',
            'options' => [
                'label' => 'Mobile'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Save',
                'id' => 'btnSaveUser'
            ]
        ]);
    }
}