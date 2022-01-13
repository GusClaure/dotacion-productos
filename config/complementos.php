<?php

return [

    'plugins' => [
        'Leaflet' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//unpkg.com/leaflet@1.7.1/dist/leaflet.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//unpkg.com/leaflet@1.7.1/dist/leaflet.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/leaflet.wms@0.2.0/dist/leaflet.wms.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.4/proj4.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/proj4leaflet/1.0.2/proj4leaflet.js'
                ],

            ],
        ],


        'dropzone' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/libreries/dropzone/dropzone.css'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/dropzone/dropzone-min.js'
                ],
            ]
        ],

        'datatable-boostrap' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '/libreries/datatable-boostrap/css/jquery.dataTables.min.css'
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/css/responsive.dataTables.min.css'
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/css/buttons.dataTables.min.css'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/js/jquery.dataTables.min.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/js/dataTables.buttons.min.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/js/jszip.min.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/js/buttons.html5.min.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/js/pdfmake.min.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/js/vfs_fonts.js'
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '/libreries/datatable-boostrap/js/dataTables.responsive.min.js'
                ]
            ]
        ],

    ],
];