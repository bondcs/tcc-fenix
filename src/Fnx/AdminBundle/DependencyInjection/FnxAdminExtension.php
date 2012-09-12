<?php

namespace Fnx\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FnxAdminExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('usuario.xml');
        $loader->load('atividade.xml');
        $loader->load('escala.xml');
//        $this->loadUsuario($loader);
//        $this->loadAtividade($loader);
    }
    
//    public function loadUsuario(Loader\XmlFileLoader $loader){
//        
//        $loader->load('usuario.xml');
//        
//    }
//    
//    public function loadAtividade(Loader\XmlFileLoader $loader){
//        
//        $loader->load('atividade.xml');
//        
//    }
}
