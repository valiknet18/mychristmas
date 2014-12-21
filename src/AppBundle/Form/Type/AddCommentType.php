<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author')
            ->add('description')
            ->add('type', 'choice', array(
                    'choices' => array(
                        '1' => 'Like' ,
                        '0' => 'Dislike'
                    )
                )
            );
    }
    public function setDefaults(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment',
        ));
    }

    public function getName()
    {
        return 'addComment';
    }
} 