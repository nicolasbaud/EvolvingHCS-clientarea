<?php

return [
    'environment' => [
        'database' => [
            'host_warning' => 'Il est fortement recommandé de ne pas utiliser "localhost" comme hôte de votre base de données, car nous avons constaté de fréquents problèmes de connexion de socket. Si vous souhaitez utiliser une connexion locale, vous devez utiliser "127.0.0.1".',
            'host' => 'Hôte de la base de données',
            'port' => 'Port de la base de données',
            'database' => 'Nom de la base de données',
            'username_warning' => 'L\'utilisation du compte "root" pour les connexions MySQL n\'est pas seulement très mal vue, elle n\'est pas non plus autorisée par cette application. Vous devrez avoir créé un utilisateur MySQL pour ce logiciel.',
            'username' => 'Nom d\'utilisateur de la base de données',
            'password_defined' => 'Il semble que vous ayez déjà défini un mot de passe de connexion MySQL, voulez-vous le changer ?',
            'password' => 'Mot de passe de la base de données',
            'connection_error' => 'Impossible de se connecter au serveur MySQL à l\'aide des informations d\'identification fournies. L\'erreur renvoyée est ":error".',
            'creds_not_saved' => 'Vos informations de connexion n\'ont PAS été enregistrées. Vous devrez fournir des informations de connexion valides avant de poursuivre.',
            'try_again' => 'Retournez-y et essayez à nouveau ?',
        ],
        'app' => [
            'app_url_help' => 'L\'URL de l\'application DOIT commencer par https:// ou http:// selon que vous utilisez SSL ou non. Si vous n\'incluez pas le schéma, vos courriels et autres contenus seront liés à un mauvais emplacement.',
            'app_url' => 'Application URL',
            'timezone_help' => 'Le fuseau horaire doit correspondre à l\'un des fuseaux horaires supportés par PHP. Si vous n\'êtes pas sûr, veuillez vous référer à http://php.net/manual/en/timezones.php.',
            'timezone' => 'Fuseau horaire de l\'application',
            'cache_driver' => 'Pilote de cache',
            'session_driver' => 'Conducteur de séance',
            'queue_driver' => 'Pilote de queue',
            'using_redis' => 'Vous avez sélectionné le pilote Redis pour une ou plusieurs options, veuillez fournir des informations de connexion valides ci-dessous. Dans la plupart des cas, vous pouvez utiliser les valeurs par défaut fournies, à moins que vous n\'ayez modifié votre configuration',
            'redis_host' => 'Redis Host',
            'redis_password' => 'Mot de passe Redis',
            'redis_pass_help' => 'Par défaut, une instance de serveur Redis n\'a pas de mot de passe car elle fonctionne localement et est inaccessible au monde extérieur. Si c\'est le cas, appuyez simplement sur la touche Entrée sans saisir de valeur.',
            'redis_port' => 'Port Redis',
            'redis_pass_defined' => 'Il semble qu\'un mot de passe soit déjà défini pour Redis, voulez-vous le changer ?',
        ],
    ],
];