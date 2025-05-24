<?php

return [
    'resources' => [
        'label'                  => 'Nhật ký hoạt động',
        'plural_label'           => 'Nhật ký hoạt động',
        'navigation_item'        => true,
        'navigation_group'       => null,
        'navigation_icon'        => 'heroicon-o-shield-check',
        'navigation_sort'        => null,
        'default_sort_column'    => 'id',
        'default_sort_direction' => 'desc',
        'navigation_count_badge' => false,
        'resource'               => \Rmsramos\Activitylog\Resources\ActivitylogResource::class,
    ],
    'datetime_format' => 'd/m/Y H:i:s',
];
