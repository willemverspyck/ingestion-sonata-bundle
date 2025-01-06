<?php

namespace Spyck\IngestionSonataBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DateRangePickerType;
use Spyck\IngestionBundle\Entity\Job;
use Spyck\IngestionSonataBundle\Controller\JobController;
use Spyck\SonataExtension\Filter\DateRangeFilter;
use Spyck\SonataExtension\Utility\DateTimeUtility;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('sonata.admin', [
    'controller' => JobController::class,
    'group' => 'Ingestion',
    'manager_type' => 'orm',
    'model_class' => Job::class,
    'label' => 'Job',
])]
final class JobAdmin extends AbstractAdmin
{
    protected function getRemoveRoutes(): iterable
    {
        yield 'create';
        yield 'delete';
        yield 'edit';
    }

    protected function getAddRoutes(): iterable
    {
        yield 'message';
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('source')
            ->add('code')
            ->add('processed')
            ->add('active')
            ->add('timestampCreated', DateRangeFilter::class, [
                'field_type' => DateRangePickerType::class,
            ])
            ->add('timestampUpdated', DateRangeFilter::class, [
                'field_type' => DateRangePickerType::class,
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->tab('tab1')
                ->with('tab1_block1')
                    ->add('source')
                    ->add('code')
                    ->add('data')
                    ->add('messages')
                    ->add('processed')
                    ->add('active')
                    ->add('timestampCreated', null, [
                        'format' => DateTimeUtility::FORMAT_DATETIME,
                    ])
                    ->add('timestampUpdated', null, [
                        'format' => DateTimeUtility::FORMAT_DATETIME,
                    ])
                ->end()
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('source')
            ->add('code')
            ->add('processed')
            ->add('active')
            ->add('timestampCreated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ])
            ->add('timestampUpdated', null, [
                'format' => DateTimeUtility::FORMAT_DATETIME,
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'message' => [
                        'template' => '@SpyckIngestionSonata/job/list_action_message.html.twig',
                    ],
                ],
            ]);
    }
}
