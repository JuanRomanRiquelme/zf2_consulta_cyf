<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

// El original del skeleton app
/*
return array(
'db' => array(
    'driver'         => 'Pdo',
    'dsn'            => 'mysql:dbname=zf2_tutorial_abegue;host=devel-mysql1.jusbaires.gov.ar',
    'driver_options' => array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    ),
),
'service_manager' => array(
    'factories' => array(
        'Zend\Db\Adapter\Adapter'
                => 'Zend\Db\Adapter\AdapterServiceFactory',
    ),
),
);
*/
// Para Habilitar el profiler para el DevTools  
   
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($sm) {
                $config = $sm->get("config");
                $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter($config['db']);
                $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler);
                $adapter->injectProfilingStatementPrototype();
                return $adapter;
            },
            'Zend\Log' => function ($sm) {
                $log = new Zend\Log\Logger();
                $writer = new Zend\Log\Writer\Stream('./data/logs/logfile');
                $log->addWriter($writer);
    
                return $log;
            },

        ),
    ),
);