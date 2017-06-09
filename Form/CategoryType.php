<?php

namespace FlowFusion\BlogBundle\Form;

use FlowFusion\BlogBundle\Entity\Category;
use FlowFusion\BlogBundle\Entity\Comment;
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
                'label' => 'backend.form.title',
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'backend.form.description',
            ])
            ->add('status', ChoiceType::class, [
                'required' => true,
                'label' => 'backend.form.status',
                'choices' => [
                    'backend.form.status.draft' => BlogService::POST_STATUS_DRAFT,
                    'backend.form.status.published' => BlogService::POST_STATUS_PUBLISHED,
                    'backend.form.status.deleted' => BlogService::POST_STATUS_DELETED,
                ]
            ])
            ->add('parent', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'label' => 'backend.form.title',
            ])
            ->add('showInMenu', CheckboxType::class, [
                'required' => false,
                'label' => 'backend.form.show_in_menu',
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Category::class
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
