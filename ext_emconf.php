<?php

$EM_CONF['alt_text_checker'] = [
    'title' => 'Alt Text Checker',
    'description' => '"Alternative Text Checker": Adds a warning icon to indicate that a file or some of its references do not have alternative text (Alt-Text) set.',
    'category' => 'fe',
    'author' => 'Dev Leuchtfeuer',
    'author_email' => 'dev@Leuchtfeuer.com',
    'author_company' => 'Leuchtfeuer Digital Marketing',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
