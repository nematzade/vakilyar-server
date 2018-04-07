<?php

namespace Cheene\ContentBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class PageDatatable
 *
 * @package Cheene\ContentBundle\Datatables
 */
class PageDatatable extends AbstractDatatableView
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
            'url' => $this->router->generate('backend_page_index_results'),
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
            ->add('title', 'column', array(
                'title' => 'Title',
            ))
            ->add('releaseDate', 'datetime', array(
                'title' => 'ReleaseDate',
            ))
            ->add('content', 'column', array(
                'title' => 'Content',
            ))
            ->add('pageImageName', 'column', array(
                'title' => 'PageImageName',
            ))
            ->add('draft', 'boolean', array(
                'title' => 'Draft',
            ))
            ->add('created_at', 'datetime', array(
                'title' => 'Created_at',
            ))
            ->add('updated_at', 'datetime', array(
                'title' => 'Updated_at',
            ))
            ->add('created_by.id', 'column', array(
                'title' => 'Created_by Id',
            ))
            ->add('created_by.username', 'column', array(
                'title' => 'Created_by Username',
            ))
            ->add('created_by.salt', 'column', array(
                'title' => 'Created_by Salt',
            ))
            ->add('created_by.email', 'column', array(
                'title' => 'Created_by Email',
            ))
            ->add('created_by.password', 'column', array(
                'title' => 'Created_by Password',
            ))
            ->add('created_by.type', 'column', array(
                'title' => 'Created_by Type',
            ))
            ->add('created_by.status', 'column', array(
                'title' => 'Created_by Status',
            ))
            ->add('created_by.firstname', 'column', array(
                'title' => 'Created_by Firstname',
            ))
            ->add('created_by.lastname', 'column', array(
                'title' => 'Created_by Lastname',
            ))
            ->add('created_by.cellphone', 'column', array(
                'title' => 'Created_by Cellphone',
            ))
            ->add('created_by.sex', 'column', array(
                'title' => 'Created_by Sex',
            ))
            ->add('created_by.comment', 'column', array(
                'title' => 'Created_by Comment',
            ))
            ->add('created_by.global', 'column', array(
                'title' => 'Created_by Global',
            ))
            ->add('created_by.visible', 'column', array(
                'title' => 'Created_by Visible',
            ))
            ->add('created_by.birthday', 'column', array(
                'title' => 'Created_by Birthday',
            ))
            ->add('created_by.created_at', 'column', array(
                'title' => 'Created_by Created_at',
            ))
            ->add('created_by.updated_at', 'column', array(
                'title' => 'Created_by Updated_at',
            ))
            ->add('created_by.locale', 'column', array(
                'title' => 'Created_by Locale',
            ))
            ->add('created_by.mobileVerificationToken', 'column', array(
                'title' => 'Created_by MobileVerificationToken',
            ))
            ->add('created_by.isMobileVerified', 'column', array(
                'title' => 'Created_by IsMobileVerified',
            ))
            ->add('created_by.nationalCode', 'column', array(
                'title' => 'Created_by NationalCode',
            ))
            ->add('created_by.profileImageName', 'column', array(
                'title' => 'Created_by ProfileImageName',
            ))
            ->add('created_by.imageConfirmed', 'column', array(
                'title' => 'Created_by ImageConfirmed',
            ))
            ->add('created_by.lastSeen', 'column', array(
                'title' => 'Created_by LastSeen',
            ))
            ->add('created_by.deleted', 'column', array(
                'title' => 'Created_by Deleted',
            ))
            ->add('updated_by.id', 'column', array(
                'title' => 'Updated_by Id',
            ))
            ->add('updated_by.username', 'column', array(
                'title' => 'Updated_by Username',
            ))
            ->add('updated_by.salt', 'column', array(
                'title' => 'Updated_by Salt',
            ))
            ->add('updated_by.email', 'column', array(
                'title' => 'Updated_by Email',
            ))
            ->add('updated_by.password', 'column', array(
                'title' => 'Updated_by Password',
            ))
            ->add('updated_by.type', 'column', array(
                'title' => 'Updated_by Type',
            ))
            ->add('updated_by.status', 'column', array(
                'title' => 'Updated_by Status',
            ))
            ->add('updated_by.firstname', 'column', array(
                'title' => 'Updated_by Firstname',
            ))
            ->add('updated_by.lastname', 'column', array(
                'title' => 'Updated_by Lastname',
            ))
            ->add('updated_by.cellphone', 'column', array(
                'title' => 'Updated_by Cellphone',
            ))
            ->add('updated_by.sex', 'column', array(
                'title' => 'Updated_by Sex',
            ))
            ->add('updated_by.comment', 'column', array(
                'title' => 'Updated_by Comment',
            ))
            ->add('updated_by.global', 'column', array(
                'title' => 'Updated_by Global',
            ))
            ->add('updated_by.visible', 'column', array(
                'title' => 'Updated_by Visible',
            ))
            ->add('updated_by.birthday', 'column', array(
                'title' => 'Updated_by Birthday',
            ))
            ->add('updated_by.created_at', 'column', array(
                'title' => 'Updated_by Created_at',
            ))
            ->add('updated_by.updated_at', 'column', array(
                'title' => 'Updated_by Updated_at',
            ))
            ->add('updated_by.locale', 'column', array(
                'title' => 'Updated_by Locale',
            ))
            ->add('updated_by.mobileVerificationToken', 'column', array(
                'title' => 'Updated_by MobileVerificationToken',
            ))
            ->add('updated_by.isMobileVerified', 'column', array(
                'title' => 'Updated_by IsMobileVerified',
            ))
            ->add('updated_by.nationalCode', 'column', array(
                'title' => 'Updated_by NationalCode',
            ))
            ->add('updated_by.profileImageName', 'column', array(
                'title' => 'Updated_by ProfileImageName',
            ))
            ->add('updated_by.imageConfirmed', 'column', array(
                'title' => 'Updated_by ImageConfirmed',
            ))
            ->add('updated_by.lastSeen', 'column', array(
                'title' => 'Updated_by LastSeen',
            ))
            ->add('updated_by.deleted', 'column', array(
                'title' => 'Updated_by Deleted',
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'page_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'page_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
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
        return 'Cheene\ContentBundle\Entity\Page';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'page_datatable';
    }
}
