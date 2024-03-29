<?php

namespace Cheene\UserBundle\Entity\Repository;

use Cheene\UserBundle\Entity\Constants\UserActivityTrackingConstants;
use Cheene\UserBundle\Entity\Constants\UserConstants;
use Cheene\UserBundle\Entity\Role;
use Cheene\UserBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{
    /**
     * Are username and email already exist?
     *
     * @param $username
     * @param $email
     * @return bool
     * @throws NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isAlreadyExist($username, $email)
    {
        $qb = $this->createQueryBuilder('user');
        $qb
            ->select('COUNT(u) as user_count')
            ->from('CheeneUserBundle:User', 'u')
            ->where($qb->expr()->eq('u.username', ':username'))
            ->setParameter('username', $username);

        if (!empty($email)) {
            $qb->orWhere($qb->expr()->eq('u.email', ':email'))->setParameter('email', $email);
        }

        return intval($qb->getQuery()->getSingleScalarResult()) > 0 ? true : false;
    }
 

    /**
     * Is username already exist?
     *
     * @param $username
     * @return bool
     * @throws NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isUsernameExists($username)
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('COUNT(u) as user_count')
            ->from('CheeneUserBundle:User', 'u')
            ->where($qb->expr()->eq('u.username', ':username'))
            ->setParameter('username', $username);

        return intval($qb->getQuery()->getSingleScalarResult()) > 0 ? true : false;
    }

    /**
     * Is email already exist?
     *
     * @param $email
     * @return bool
     * @throws NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isEmailExists($email)
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('COUNT(u) as user_count')
            ->from('CheeneUserBundle:User', 'u')
            ->where($qb->expr()->eq('u.email', ':email'))
            ->setParameter('email', $email);

        return intval($qb->getQuery()->getSingleScalarResult()) > 0 ? true : false;
    }

    public function newUser()
    {
        return new User();
    }

    public function delete(UserInterface $user)
    {
        $now = new \DateTime();
        $time = $now->format('Y-m-d H:i:s');
        $user->setUsername("Deleted" . $time . $user->getUsername());
        $user->setStatus(UserConstants::STATUS_DELETED);
        $this->save($user);
    }

    public function save(UserInterface $user)
    {
        $this->getEntityManager()->persist($user);
    }

    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->select('u, r')
            ->leftJoin('u.roles', 'r')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin AcmeUserBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function loadUserByUsernameOrEmail($data)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('a')
            ->from('CheeneUserBundle:User', 'a')
            ->where('a.username = :username OR a.email = :email')
            ->setParameter('username', $data)
            ->setParameter('email', $data);

        return $qb->getQuery()->getSingleResult();
    }
 
    /**
     * Are cellphone already exist?
     *
     * @param $cellphone
     * @return bool
     * @throws NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isCellphoneAlreadyExist($cellphone)
    {
        $qb = $this->createQueryBuilder('user');
        $qb
            ->select('COUNT(u) as user_count')
            ->from('CheeneUserBundle:User', 'u')
            ->where($qb->expr()->eq('user.cellphone', ':cellphone'))
            ->setParameter('cellphone', $cellphone);
        return intval($qb->getQuery()->getSingleScalarResult()) > 0 ? true : false;
    }


    /**
     * is cellphone verified?
     *
     * @param $user
     * @param $token
     * @return bool
     * @internal param $cellphone
     */
    public function isCellphoneVerified($user, $token)
    {
        $qb = $this->createQueryBuilder('user');
        $qb
            ->select('COUNT(u) as user_count')
            ->from('CheeneUserBundle:User', 'u')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('u.mobileVerificationToken', ':token')),
                $qb->expr()->eq('u', ':user')
            )
            ->setParameter('token', $token)
            ->setParameter('user', $user);

        return intval($qb->getQuery()->getSingleScalarResult()) > 0 ? true : false;
    }


    /**
     * @param $_query
     * @return array
     */
    public function searchForUser($_query)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('concat(user.firstname , \' \', user.lastname) as fullname', 'user.id as id')
            ->from('CheeneUserBundle:User', 'user')
            ->where($qb->expr()->orX(
                $qb->expr()->like('concat(user.firstname , \' \', user.lastname)', ':user_name'),
                $qb->expr()->like('user.email', ':user_name'),
                $qb->expr()->like('user.username', ':user_name')
            ))
            ->setParameter('user_name', "%$_query%");;
        $result = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $result;
    }

    /**
     * @return array
     */
    public function countAllUsers()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('count(u.id)')
            ->from('CheeneUserBundle:User', 'u')
            ->where($qb->expr()->eq('u.status', ':status'))
            ->andWhere($qb->expr()->lt('u.id', ':id'))
            ->orderBy('u.id', 'desc')
            ->setParameter('id', 259507)
            ->setParameter('status', UserConstants::STATUS_ACTIVE);
        return intval($qb->getQuery()->getSingleScalarResult());
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return ($this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName()));
    }


    /**
     * Is national code already exist?
     *
     * @param $nationalCode
     * @return bool
     * @throws NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isNationalCodeExist($nationalCode)
    {
        $qb = $this->createQueryBuilder('user');
        $qb->select('COUNT(u) as user_count')
            ->from('CheeneUserBundle:User', 'u')
            ->where($qb->expr()->eq('user.nationalCode', ':national_code'))
            ->setParameter('national_code', $nationalCode);

        return intval($qb->getQuery()->getSingleScalarResult()) > 0 ? true : false;
    }



}