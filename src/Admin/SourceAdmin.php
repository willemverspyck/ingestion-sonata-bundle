<?php

namespace Spyck\IngestionSonataBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\Form\Type\CollectionType;
use Spyck\IngestionBundle\Entity\Source;
use Spyck\IngestionSonataBundle\Controller\SourceController;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('sonata.admin', [
    'controller' => SourceController::class,
    'group' => 'Ingestion',
    'manager_type' => 'orm',
    'model_class' => Source::class,
    'label' => 'Source',
])]
final class SourceAdmin extends AbstractAdmin
{
    protected function getAddRoutes(): iterable
    {
        yield 'clone';
        yield 'message';
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->tab('tab1')
                ->with('tab1_block1')
                    ->add('module', null, [
                        'required' => true,
                    ])
                    ->add('name', null, [
                        'required' => true,
                    ])
                    ->add('url', null, [
                        'required' => true,
                    ])
                    ->add('type', ChoiceFieldMaskType::class, [
                        'choices' => Source::getTypes(true),
                    ])
                    ->add('maps', CollectionType::class, ['by_reference' => false], [
                        'edit' => 'inline',
                        'inline' => 'table',
                    ])
                    ->add('code', null, [
                        'required' => true,
                    ])
                    ->add('codeUrl', null, [
                        'required' => false,
                    ])
                    ->add('path', null, [
                        'required' => false,
                    ])
                    ->add('active', null, [
                        'required' => false,
                    ])
                ->end()
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
            ->add('active');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name')
            ->add('active')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'clone' => [
                        'template' => 'admin/list_action_clone.html.twig',
                    ],
                    'delete' => [],
                    'message' => [
                        'template' => '@SpyckIngestionSonata/job/list_action_message.html.twig',
                    ],
                ],
            ]);
    }
}
