<?php
return [
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => OMEKA_PATH . '/modules/ItemHierarchy/language',
                'pattern' => '%s.mo',
                'text_domain' => null,
            ],
        ],
    ],
    'api_adapters' => [
        'invokables' => [
            'item_hierarchy' => 'ItemHierarchy\Api\Adapter\ItemHierarchyAdapter',
            'item_hierarchy_grouping' => 'ItemHierarchy\Api\Adapter\ItemHierarchyGroupingAdapter',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'ItemHierarchy\Controller\Index' => 'ItemHierarchy\Controller\IndexController',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            OMEKA_PATH . '/modules/ItemHierarchy/view',
        ],
    ],
    'block_layouts' => [
        'invokables' => [
            'itemHierarchy' => ItemHierarchy\Site\BlockLayout\ItemHierarchy::class,
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'hierarchyHelper' => ItemHierarchy\View\Helper\HierarchyHelper::class,
        ],
    ],
    'entity_manager' => [
        'mapping_classes_paths' => [
            OMEKA_PATH . '/modules/ItemHierarchy/src/Entity',
        ],
        'proxy_paths' => [
            OMEKA_PATH . '/modules/ItemHierarchy/data/doctrine-proxies',
        ],
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'item-hierarchy' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/item-hierarchy',
                            'defaults' => [
                                '__NAMESPACE__' => 'ItemHierarchy\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'action' => [
                                'type' => \Laminas\Router\Http\Segment::class,
                                'options' => [
                                    'route' => '[/:action]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'AdminModule' => [
            [
                'label' => 'Item Hierarchy', // @translate
                'route' => 'admin/item-hierarchy',
                'resource' => 'ItemHierarchy\Controller\Index',
            ],
        ],
    ],
];
