<?php

namespace Cheene\UserBundle\Datatables;

use Cheene\UserBundle\Entity\Constants\UserConstants;
use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class UserDatatable
 *
 * @package Cheene\UserBundle\Datatables
 */
class UserDatatable extends AbstractDatatableView
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
            'url' => $this->router->generate('backend_user_results'),
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
            ->add('firstname', 'column', array('visible' => false))
            ->add('lastname', 'column', array('visible' => false))
            ->add('name', 'virtual', array(
                'title' => $this->translator->trans('label.users.fullname', array(), 'labels'),
            ))
            ->add('username', 'column', array(
                'title' => $this->translator->trans('label.auth.username', array(), 'labels'),
                'searchable' => true,
            ))
            ->add('email', 'column', array(
                'title' => $this->translator->trans('label.email', array(), 'labels'),
                'searchable' => true,
            ))
            ->add('status', 'column', array(
                'title' => $this->translator->trans('label.users.status', array(), 'labels'),
            ))
            ->add('lastSeen', 'timeago', array(
                'title' => $this->translator->trans('label.users.lastseen', array(), 'labels'),
            ))
            ->add(null, 'action', array(
                    'title' => $this->translator->trans('label.actions', array(), 'labels'),
                    'width' => '80px',
                    'actions' => array(
                        array(
                            'route' => 'backend_user_edit',
                            'route_parameters' => array(
                                'id' => 'id'
                            ),
                            'icon' => 'fa fa-pencil',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => $this->translator->trans('button.edit', array(), 'buttons'),
                                'class' => 'btn btn-xs purple',
                                'role' => 'button'
                            ),
                        ),
                        array(
                            'route' => 'backend_user_role_edit',
                            'route_parameters' => array(
                                'id' => 'id'
                            ),
                            'icon' => 'fa fa-lock',
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => $this->translator->trans('button.role.edit', array(), 'buttons'),
                                'class' => 'edit_button btn btn-xs blue',
                                'role' => 'button',
                                'target' => '_blank',
                            ),
                        ),

                    ),
                )
            );
    }


    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        $formatter = function ($line) {
            $line["name"] = $line["firstname"] . " " . $line["lastname"];
            /** @var \DateTime $timeago */
            $timeago = $line['lastSeen'];
            $defaultTimestamp = new \DateTime('1997-01-01 00:00:00');
            if ($timeago->getTimestamp() == $defaultTimestamp->getTimestamp()) {
                $line['lastSeen'] = null;
            }

            if ($line['status'] != '') {
                $line['status'] = $this->translator->trans(UserConstants::$user_statuses[$line['status']], array(), 'labels');
            }

            return $line;
        };
        return $formatter;
    }


    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'Cheene\UserBundle\Entity\User';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_datatable';
    }
}
