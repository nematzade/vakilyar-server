<?php

namespace Cheene\UserBundle\DataFixtures\ORM;

use Cheene\UserBundle\Entity\Action;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadActionData
 * @package Cheene\UserBundle\DataFixtures\ORM
 */
class LoadActionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $indexAction = new Action();
        $indexAction->setCode('ACTION_USER_INDEX');
        $indexAction->setTitle('User -> Index');
        $indexAction->setVisible(true);
        $manager->persist($indexAction);
        $this->addReference('user-index-action', $indexAction);

        $createAction = new Action();
        $createAction->setCode('ACTION_USER_NEW');
        $createAction->setTitle('User -> Create');
        $createAction->setVisible(true);
        $manager->persist($createAction);
        $this->addReference('user-create-action', $createAction);

        $showAction = new Action();
        $showAction->setCode('ACTION_USER_SHOW');
        $showAction->setTitle('User -> Create');
        $showAction->setVisible(true);
        $manager->persist($showAction);
        $this->addReference('user-show-action', $showAction);

        $deleteAction = new Action();
        $deleteAction->setCode('ACTION_USER_DELETE');
        $deleteAction->setTitle('User -> Delete');
        $deleteAction->setVisible(true);
        $manager->persist($deleteAction);
        $this->addReference('user-delete-action', $deleteAction);

        $editAction = new Action();
        $editAction->setCode('ACTION_USER_EDIT');
        $editAction->setTitle('User -> Edit');
        $editAction->setVisible(true);
        $manager->persist($editAction);
        $this->addReference('user-edit-action', $editAction);

        $updateAction = new Action();
        $updateAction->setCode('ACTION_USER_UPDATE');
        $updateAction->setTitle('User -> Update');
        $updateAction->setVisible(true);
        $manager->persist($updateAction);
        $this->addReference('user-update-action', $updateAction);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }
}
