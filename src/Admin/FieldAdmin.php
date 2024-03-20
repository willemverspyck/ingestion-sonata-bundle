<?php

namespace Spyck\IngestionSonataBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Spyck\IngestionBundle\Entity\Field;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('sonata.admin', [
    'group' => 'Ingestion',
    'manager_type' => 'orm',
    'model_class' => Field::class,
    'label' => 'Field',
])]
final class FieldAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('module')
            ->add('name')
            ->add('code');
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
                    ->add('code', null, [
                        'required' => true,
                    ])
                    ->add('multiple', null, [
                        'required' => false,
                    ])
                ->end()
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('module')
            ->add('name')
            ->add('code')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }
}
