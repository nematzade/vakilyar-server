<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ## Symfony Bundles
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            ## Third Party Bundles
            new Snc\RedisBundle\SncRedisBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Okapon\DoctrineSetTypeBundle\OkaponDoctrineSetTypeBundle(),
            new Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),
            new SymfonyPersia\JalaliDateBundle\SymfonyPersiaJalaliDateBundle(),
            new cayetanosoriano\HashidsBundle\cayetanosorianoHashidsBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Sg\DatatablesBundle\SgDatatablesBundle(),
            new EightPoints\Bundle\GuzzleBundle\GuzzleBundle(),
            new Misd\PhoneNumberBundle\MisdPhoneNumberBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new BoShurik\TelegramBotBundle\BoShurikTelegramBotBundle,

            ## Cheene Bundles
            new Cheene\CoreBundle\CheeneCoreBundle(),
            new Cheene\UserBundle\CheeneUserBundle(),
            new Cheene\BackendBundle\CheeneBackendBundle(),
            
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
