<?php

namespace Cheene\CoreBundle\Console\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Cheene\UserBundle\Entity\Action;

class ActionLoaderCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager instance of Entity Manager
     */
    private $em;

    protected function configure()
    {
        $this
            ->setName('cheene:actions:load')
            ->setDescription('Sourcecode Scanner for new Actions')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $router = $this->getContainer()->get('router');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $actionRepo = $em->getRepository('CheeneUserBundle:Action');

        $collection = $router->getRouteCollection();
        $allRoutes = $collection->all();

        foreach ($allRoutes as $route) {
            $defaults = $route->getDefaults();
            if (isset($defaults['_controller'])) {
                preg_match('/(.*)\\\(.*)Bundle\\\Controller\\\(.*)Controller::(.*)Action/', $defaults['_controller'], $matches);
                if(count($matches) === 5 && $matches[2] === 'Backend') {
                    $controller_name = $matches[3];
                    $action_name = $matches[4];

                    $action_code = 'ACTION_'.strtoupper($controller_name).'_'.strtoupper($action_name);
                    
                    $action_name_words = preg_split('/(?=[A-Z])/', $action_name);
                    $action_name_beautified = implode(' ', $action_name_words);

                    $controller_name_words = preg_split('/(?=[A-Z])/', $controller_name);
                    $controller_name_beautified = implode(' ', $controller_name_words);

                    $action_title = $controller_name_beautified.' -> '.ucwords($action_name_beautified);

                    $action = $actionRepo->findOneByCode($action_code);

                    if (!$action) {
                        $action = new Action();
                    }
                    $action->setCode($action_code);
                    $action->setTitle($action_title);
                    $em->persist($action);
                }
            }
        }

        $em->flush();

        $output->writeln('<info>Data loaded successfully to database</info>');
    }
}
