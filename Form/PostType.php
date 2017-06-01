<?php

namespace FlowFusion\BlogBundle\Form;

use FlowFusion\BlogBundle\Entity\Category;
use FlowFusion\BlogBundle\Service\BlogService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Title'
            ])
            ->add('content', TextareaType::class, [
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
            ->add('comments_enabled', ChoiceType::class, [
                'required' => true,
                'label' => 'Comments enabled',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Yes' => 1,
                    'No' => 0,
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'title',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FlowFusion\BlogBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'flowfusion_blogbundle_post';
    }


}
