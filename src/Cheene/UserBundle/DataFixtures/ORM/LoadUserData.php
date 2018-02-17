<?php

namespace Cheene\UserBundle\DataFixtures\ORM;

use Cheene\UserBundle\Entity\Constants\UserConstants;
use Cheene\UserBundle\Entity\User;
use Cheene\VendorBundle\Entity\VendorUser;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use libphonenumber\PhoneNumber;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package Cheene\UserBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /** @var  ObjectManager $manager */
    private $manager;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->addReference('root-user', $this->createRootUser());
//        $this->addReference('admin-user', $this->createAdminUser());
//        $this->addReference('vendor-user', $this->createVendorUser());
//        $this->addReference('customer-test-user', $this->createCustomerTestUser());
    }

    /**
     * Create Super Admin User (root)
     * @return User
     */
    private function createRootUser()
    {
        $userModel = $this->manager->getRepository('CheeneUserBundle:User');
        $super_admin_user = $userModel->findOneBy(array('username' => 'root'));

        if (! $super_admin_user) {
            $super_admin_user = new User();
            $super_admin_user->setUsername("root");
            $super_admin_user->setFirstname("سوپر");
            $super_admin_user->setLastname("یوزر");
            $super_admin_user->setEmail("reza@seyf.fr");
            $super_admin_user->setPlainPassword('1');
            $super_admin_user->setVisible(false);
            $super_admin_user->setType(UserConstants::TYPE_BACKEND);
            $super_admin_user->setStatus(UserConstants::STATUS_ACTIVE);
            $setCellphone = new PhoneNumber();
            $setCellphone->setRawInput('+989198254644');
            $super_admin_user->setCellphone($setCellphone);
            $super_admin_user->setGlobal(true);
            $super_admin_user->setCreatedAt(new \DateTime());
            $super_admin_user->setUpdatedAt(new \DateTime());
            $super_admin_user->addRole($this->getReference('super-admin-role'));


            $userModel->save($super_admin_user);
//            $super_admin_user->setPassword($encoder->encodePassword($super_admin_user, 139420));
            $this->manager->flush();
        }

        return $super_admin_user;
    }
 

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }
}
