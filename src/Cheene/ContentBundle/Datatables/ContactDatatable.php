<?php

namespace Cheene\ContentBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class ContactDatatable
 *
 * @package Cheene\ContentBundle\Datatables
 */
class ContactDatatable extends AbstractDatatableView
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
            'url' => $this->router->generate('backend_contact_index_results'),
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
                'title' => 'Id',
            ))
            ->add('fullname', 'column', array(
                'title' => 'نام',
            ))
            ->add('email', 'column', array(
                'title' => 'ایمیل',
            ))
            ->add('telephone', 'column', array(
                'title' => 'تلفن',
            ))
            ->add('comment', 'column', array(
                'title' => 'متن',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'Cheene\ContentBundle\Entity\Contact';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'contact_datatable';
    }
}
