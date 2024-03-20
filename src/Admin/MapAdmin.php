<?php

namespace Spyck\IngestionSonataBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Spyck\IngestionBundle\Entity\Map;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('sonata.admin', [
    'group' => 'Ingestion',
    'manager_type' => 'orm',
    'model_class' => Map::class,
    'label' => 'Map',
])]
final class MapAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->tab('General')
                ->with('General fields')
                    ->add('field', null, [
                        'required' => true,
                    ])
                    ->add('code', null, [
                        'required' => false,
                    ])
                    ->add('path', null, [
                        'required' => false,
                    ])
                    ->add('value', null, [
                        'required' => false,
                    ])
                    ->add('valueUpdate', null, [
                        'required' => false,
                    ])
                    ->add('template', null, [
                        'required' => false,
                    ])
                ->end()
            ->end();
    }
}
