<?php

namespace User\Model;

use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

class User implements InputFilterAwareInterface
{
    /**
     * @var int
     */
    public int $id;
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string
     */
    public string $mobile;
    /**
     * @var
     */
    private $inputFilter;

    /**
     * @param array $data
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : 0;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->mobile = (!empty($data['mobile'])) ? $data['mobile'] : null;
    }

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filter' => [
                ['name' => ToInt::class],
            ]
        ]);

        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'filter' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validation' => [
                'name' => StringLength::class,
                'options' => [
                    'min' => 1,
                    'max' => 50,
                ],
            ]
        ]);

        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filter' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validation' => [
                'name' => StringLength::class,
                'options' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ]
        ]);

        $inputFilter->add([
            'name' => 'mobile',
            'required' => true,
            'filter' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validation' => [
                'name' => StringLength::class,
                'options' => [
                    'min' => 1,
                    'max' => 14,
                ],
            ]
        ]);

        $this->inputFilter = $inputFilter;

        return $this->inputFilter;
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter): InputFilterAwareInterface
    {
        throw new DomainException(sprintf('%s does not allow injection of an alternate input filter', __CLASS__));
    }

//    public function getArrayCopy()
//    {
//        return [
//            'id' => $this->id,
//            'name' => $this->name,
//            'email' => $this->email,
//            'mobile' => $this->mobile,
//        ];
//    }
}