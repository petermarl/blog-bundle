<?php

namespace FlowFusion\BlogBundle\Form;

use Doctrine\ORM\EntityRepository;
use FlowFusion\BlogBundle\Entity\Category;
use FlowFusion\BlogBundle\Entity\Post;
use FlowFusion\BlogBundle\Entity\Tag;
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
                'label' => 'backend.form.title',
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'backend.form.content',
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
            ->add('comments_enabled', ChoiceType::class, [
                'required' => true,
                'label' => 'backend.form.comments_enabled',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Yes' => 1,
                    'No' => 0,
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'label' => 'backend.form.categories',
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'expanded' => true,
                'label' => 'backend.form.tags',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->where('t.status = :status')
                        ->setParameter('status', BlogService::POST_STATUS_PUBLISHED)
                        ->orderBy('t.title', 'ASC');
                },
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Post::class
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
