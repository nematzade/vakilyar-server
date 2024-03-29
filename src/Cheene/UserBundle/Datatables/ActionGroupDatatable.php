<?php

namespace Cheene\UserBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class ActionGroupDatatable
 *
 * @package Cheene\UserBundle\Datatables
 */
class ActionGroupDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->features->set(array(
            'auto_width' => true,
            'defer_render' => true,
            'info' => true,
            'jquery_ui' => false,
            'length_change' => true,
            'ordering' => true,
            'paging' => true,
            'processing' => true,
            'scroll_x' => false,
            'scroll_y' => '',
            'searching' => true,
            'server_side' => true,
            'state_save' => false,
            'delay' => 0,
            'extensions' => array(),
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('backend_action_group_results'),
            'type' => 'GET'
        ));

        $this->options->set(array(
            'class' => Style::BOOTSTRAP_3_STYLE . ' table-condensed',
            'display_start' => -1,
            'dom' => 'lfrtip', // default, but not used because 'use_integration_options' = true
            'length_menu' => array(10, 25, 50, 100),
            'order_classes' => true,
            'order' => array(array(0, 'asc')),
            'order_multi' => true,
            'page_length' => 50,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' => '', // default, but not used because 'use_integration_options' = true
            'scroll_collapse' => false,
            'search_delay' => 4,
            'state_duration' => 7200,
            'stripe_classes' => array(),
            'individual_filtering' => false,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => true
        ));

        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => $this->translator->trans('label.id', array(), 'labels'),
            ))
            ->add('title', 'column', array(
                'title' => $this->translator->trans('label.title', array(), 'labels'),
            ))
            ->add('code', 'column', array(
                'title' => $this->translator->trans('label.action_groups.code', array(), 'labels'),
            ))
            ->add('visible', 'boolean', array(
                'title' => $this->translator->trans('label.visible', array(), 'labels'),
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('label.edit', array(), 'labels'),
                'actions' => array(
                    array(
                        'route' => 'backend_action_group_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('label.edit', array(), 'labels'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' =>  $this->translator->trans('label.edit', array(), 'labels'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'Cheene\UserBundle\Entity\ActionGroup';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'actiongroup_datatable';
    }
}
