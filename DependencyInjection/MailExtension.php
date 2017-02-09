<?php

namespace Chris\Bundle\MailBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MailExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        if (false === $config['sendgrid']['enabled']) {
            $config['sendgrid']['key'] = null;
            $config['sendgrid']['options'] = false;
        }

        $container->setParameter('mail_bundle.sendgrid.key', $config['sendgrid']['key']);
        $container->setParameter('mail_bundle.sendgrid.options', $config['sendgrid']['options']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('mailer.xml');
    }
}
