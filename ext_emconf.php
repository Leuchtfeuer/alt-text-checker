<?php

$EM_CONF['alt_text_checker'] = [
    'title' => 'Alt Text Checker',
    'description' => 'TYPO3 extension that adds a warning overlay icon in the File List module for files missing alternative text, and adds an Alternative text column to file reference tables in the backend.',
    'category' => 'fe',
    'author' => 'Dev Leuchtfeuer',
    'author_email' => 'dev@Leuchtfeuer.com',
    'author_company' => 'Leuchtfeuer Digital Marketing',
    'state' => 'stable',
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'extbase' => '13.4.0-13.4.99',
            'fluid' => '13.4.0-13.4.99',
            'backend' => '13.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
