<?php

namespace FlowFusion\BlogBundle\Form;

use FlowFusion\BlogBundle\Entity\Tag;
use FlowFusion\BlogBundle\Service\BlogService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'backend.form.name',
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
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Tag::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'flowfusion_blogbundle_tag';
    }


}
