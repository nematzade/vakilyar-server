<?php

namespace Cheene\UserBundle\DataFixtures\ORM;

use Cheene\UserBundle\Entity\ActionGroup;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadActionGroupsData
 * @package Cheene\UserBundle\DataFixtures\ORM
 */
class LoadActionGroupsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $action_group = $manager->getRepository('CheeneUserBundle:ActionGroup')->findOneBy(array('code' => 'USER_MANAGEMENT'));
        if (! $action_group) {
            $action_group = new ActionGroup();
            $action_group->setParent(NULL);
            $action_group->setCode('USER_MANAGEMENT');
            $action_group->setTitle('User Management');
            $action_group->setVisible(true);
            $action_group->addRole($this->getReference('super-admin-role'));
            $action_group->addAction($this->getReference('user-index-action'));
            $action_group->addAction($this->getReference('user-create-action'));
            $action_group->addAction($this->getReference('user-show-action'));
            $action_group->addAction($this->getReference('user-delete-action'));
            $action_group->addAction($this->getReference('user-edit-action'));
            $action_group->addAction($this->getReference('user-update-action'));
        }
        $manager->persist($action_group);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 4;
    }
}
