<?php

namespace FlowFusion\BlogBundle\Form;

use FlowFusion\BlogBundle\Entity\Category;
use FlowFusion\BlogBundle\Service\BlogService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Content'
            ])
            ->add('status', ChoiceType::class, [
                'required' => true,
                'label' => 'Status',
                'choices' => [
                    'Draft' => BlogService::POST_STATUS_DRAFT,
                    'Published' => BlogService::POST_STATUS_PUBLISHED,
                    'Deleted' => BlogService::POST_STATUS_DELETED,
                ]
            ])
            ->add('parent', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
            ])
            ->add('showInMenu', CheckboxType::class, [
                'required' => false,
                'label' => 'Show category in menu',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FlowFusion\BlogBundle\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'flowfusion_blogbundle_category';
    }


}
