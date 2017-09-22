<?php

namespace AppBundle\Form;

use AppBundle\Controller\managing\CategoryEditFormController;
use AppBundle\Entity\Category;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use function Symfony\Component\DependencyInjection\Tests\Fixtures\factoryFunction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->categoryId = $options['categoryId'];
        if($this->categoryId){
            $builder
                ->add('name', TextType::class)
                ->add('parent', EntityType::class, array(
                    'class' => 'AppBundle:Category',
                    'query_builder' => function (EntityRepository $er) {
                        $criteria = Criteria::create()
                            ->where(Criteria::expr()->neq('u.id', $this->categoryId))
                            ->orderBy(array('u.id' => Criteria::ASC));
                        return $er->createQueryBuilder('u')
                            ->addCriteria($criteria);

                    },
                    'choice_label' => 'name',
                ))
            ;
        }
        else {
            $builder
                ->add('name', TextType::class)
                ->add('parent', EntityType::class, array(
                    'class' => 'AppBundle:Category',
                    'choice_label' => 'name'
                ))
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Category::class,
            'categoryId' => 4,
        ));
    }
}