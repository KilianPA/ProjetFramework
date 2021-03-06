<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('captcha', 'Gregwar\CaptchaBundle\Type\CaptchaType');
        $builder->add('age');
        $builder->remove('plainPassword');
        //
}

public function getParent()
{
    return 'FOS\UserBundle\Form\Type\RegistrationFormType';
}

public function getName()
{
return 'app_user_registration';
}
}