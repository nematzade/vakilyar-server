<?php
namespace Cheene\UserBundle\Security\Authorization\Voter;

use Cheene\UserBundle\Entity\Action;
use Cheene\UserBundle\Entity\ActionGroup;
use Cheene\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ActionVoter implements VoterInterface
{
    private $prefix;
    private $em;

    public function __construct(EntityManager $em, $prefix = 'ACTION_')
    {
        $this->em = $em;
        $this->prefix = $prefix;
    }

    public function supportsAttribute($attribute)
    {
        return (0 === strpos($attribute, $this->prefix));
    }

    public function supportsClass($class)
    {
        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        // set the attribute to check against
        $actionName = $attributes[0];

        // check if the given attribute is covered by this voter
        if (! $this->supportsAttribute($actionName)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        
        /** @var User $user */
        $user = $token->getUser();
        if (! $user) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
        
        /** @var EntityManager $em */
        /** @var Action $action */
        $action = $this->em->getRepository('CheeneUserBundle:Action')->findOneBy(array('code' => $actionName));
        if (! $action) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $actionGroups = $action->getActionGroups();
        $userRoles = $user->getRoles();

        foreach ($actionGroups as $actionGroup) {
            /** @var ActionGroup $actionGroup */
            foreach ($actionGroup->getRoles() as $role) {
                if (in_array($role, $userRoles))
                    return VoterInterface::ACCESS_GRANTED;
            }
        }
        return VoterInterface::ACCESS_DENIED;
    }
}
