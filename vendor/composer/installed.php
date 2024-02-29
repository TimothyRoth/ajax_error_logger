<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '6709ac99ce14740ec3bf0ac70c7619ace0b2c19a',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '6709ac99ce14740ec3bf0ac70c7619ace0b2c19a',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'league/csv' => array(
            'pretty_version' => '9.14.0',
            'version' => '9.14.0.0',
            'reference' => '34bf0df7340b60824b9449b5c526fcc3325070d5',
            'type' => 'library',
            'install_path' => __DIR__ . '/../league/csv',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'roave/security-advisories' => array(
            'pretty_version' => 'dev-latest',
            'version' => 'dev-latest',
            'reference' => '624324975ceed0b788160bdec5b7f22125d8de14',
            'type' => 'metapackage',
            'install_path' => NULL,
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => true,
        ),
    ),
);
