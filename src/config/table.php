<?php


return [

    /*
     * Add as many attributes as you like here. These will
     * exist on all tables unless you specifically call the
     * attributes method on the returned collection itself.
     *
     * @var array
     */
    'default_table_attributes' => [
        'class' => 'table table-striped'
    ],


    /*
     * Add as many attributes you like here. These
     * attributes will exist on all table columns
     * which have been specifically set to be hidden
     * using the hideFromIndex() function on the collection
     * itself.
     *
     * @var array
     */
    'default_hidden_column_attributes' => [
        'class' => 'd-none'
    ],

    /*
     * These class names are used for showing the icons
     * for a collection that is currently sorted. If you use
     * something like font awesome, be sure to set the correct
     * classes here, such as 'fa fa-sort-desc'
     *
     * @var array
     */
    'default_sort_icons' => [
        'sort_icon' => '<i class="fas fa-sort ml-2"></i>',
        'asc_sort_icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="current-fill w-3 icon"><path class="heroicon-ui" d="M8.7 14.7a1 1 0 0 1-1.4-1.4l4-4a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1-1.4 1.4L12 11.42l-3.3 3.3z"/></svg>',
        'desc_sort_icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="current-fill w-3 icon"><path class="heroicon-ui" d="M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z"/></svg>'
    ],


    'default_form_attributes' => [
        'class' => 'needs-validation'
    ],

    'force_exclude_fields' => [
        'id',
        'textarea',
        'tinymce'
    ]

];
