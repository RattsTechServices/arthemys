<?php
// lang/en/manager.php

return [

    /******** Menu Itens Translactions ***********/
    'menu_applications'         => [
        "single"                    => "Application",
        "plural"                    => "Applications",
    ],
    'menu_registers'            => [
        "single"                    => "Register",
        "plural"                    => "Registers",
    ],
    'menu_inputs'               => [
        "single"                    => "Input",
        "plural"                    => "Inputs",
    ],
    'menu_steps'                => [
        "single"                    => "Step",
        "plural"                    => "Steps",
    ],
    'menu_updater'              => [
        "single"                    => "Updater",
        "plural"                    => "Update",
    ],
    'menu_themes'                => [
        "single"                    => "Theme",
        "plural"                    => "Themes",
    ],
    'menu_users'                => [
        "single"                    => "User",
        "plural"                    => "Users",
    ],

    /******* Action Itens Translactions **********/
    'label_applications'        => [
        "single"                    => "Application",
        "plural"                    => "Applications",
    ],
    'label_registers'           => [
        "single"                    => "Application Register",
        "plural"                    => "Application Registers",
    ],
    'label_inputs'              => [
        "single"                    => "Step Input",
        "plural"                    => "Step Inputs",
    ],
    'label_steps'               => [
        "single"                    => "Register Step",
        "plural"                    => "Register Steps",
    ],
    'label_updater'             => [
        "single"                    => "Software Update",
        "plural"                    => "Software Updates",
    ],
    'label_themes'              => [
        "single"                    => "Theme / plugin",
        "plural"                    => "Themes and plugins",
    ],
    'label_users'               => [
        "single"                    => "System user",
        "plural"                    => "System users",
    ],
    /******* Table and form lables Translactions **********/
    'users_resources' => [
        'table' => [
            'id' => '#ID',
            'name' => "Name",
            'email' => "Email",
            'phone' => "Phone",
            'created_at' => "Created at",
            "_defaults" => [
                'phone' => "empty"
            ],
            "_masks" => [
                'created_at' => "Y-m-d H:i"
            ]
        ],
        'form' => [
            'input' => [
                'name' => "Name",
                'email' => "Email",
                'phone' => "Phone",
                'password' => "Password",
                'created_at' => "Created at"
            ],
            'placeholder' => [
                'name' => "Complete name",
                'email' => "email@domain.com",
                'phone' => "+1 (555) 555-1234",
                'password' => "8 to 16 digits with numbers and leters",
            ],
            'mask' => [
                'phone' => '+9 (999) 999-9999'
            ]
        ]
    ],
    'theme_manager_resources' => [
        'table' => [
            'id' => '#ID',
            'is_active' => 'Active',
            'title' => 'Title',
            'slug' => 'Slug',
            'namespace' => 'Name Space',
            'created_at' => 'Created at',
            '_masks' => [
                'created_at' => 'Y-m-d H:i'
            ]
        ],
        'form' => [
            'action' => [
                'upload' => 'Theme upload'
            ],
            'input' => [
                'file' => 'File uploader',
            ],
            'placeholder' => [
                'file' => 'Attach a file .zip from your theme at size 100Mb'
            ]
        ],
        'notifications' => [
            'file' => [
                'success' => [
                    'title' => 'Theme loaded with success',
                ],
                'error' => [
                    'title' => 'Oops, a error is ocurred!'
                ]
            ]
        ]
    ],
    'software_update_resources' => [
        'table' => [
            'id' => '#ID',
            'version' => 'Version',
            'repository' => 'Repository',
            'artefact' => 'Artefact',
            'size' => 'Size',
            'created_at' => 'Created at',
            '_masks' => [
                'created_at' => 'Y-m-d H:i'
            ]
        ]
    ],
    'register_step_resource' => [
        'table' => [
            'id' => '#ID',
            'title' => 'Title',
            'status' => 'Status',
            'client_application' => 'Application',
            'register_inputs' => 'Register Inputs',
            'created_at' => 'Created date',
            '_tooltips' => [
                'title' => 'Title from step. This item can e modfied in edit action.',
                'status' => 'Status from step. defines if this item is Enable or Disable.',
                'client_application' => 'Reference application ID',
                'register_inputs' => 'Number of iputs in this item',
                'created_at' => 'Date of item creation'
            ]
        ],
        'form' => [
            'input' => [
                'title' => 'Title for step',
                'description' => 'Description',
                'step' => 'Step number',
                'identify' => 'Slug ID',
                'client_application_id' => 'Select application',
                'status' => 'Status',
                '_select' => [
                    'status' => ['Denny', 'Allow']
                ]
            ],
            'placeholder' => [
                'title' => 'add a title for step',
                'description' => 'add a description for step',
                'step' => 'numer for step',
                'identify' => 'slug ID for Step',
                'client_application_id' => 'Select application to use step',
                'status' => 'Select status'

            ]
        ]
    ],
    'register_input_resource' => [
        'table' => [
            'id' => '#ID',
            'register_step' => 'Register Step',
            'label' => 'Label',
            'type' => 'Input Type',
            'required' => 'Required item',
            'is_client_register_collection' => 'Pre-form',
            'created_at' => 'Created at'
        ],
        'form' => [
            'input' => [
                'label' => 'Label',
                'register_step_id' => 'Register step',
                'client_application_id' => 'Client application',
                'type' => 'Type',
                'name' => 'Name',
                'placeholder' => 'Placeholder',
                'value' => 'Value',
                'mask' => 'Mask',
                'required' => 'Required',
                'options' => 'Select options',
                'ai_auto_verify' => 'AI Auto verify',
                'html' => 'HTML code',
                '_select' => [
                    'type' => [
                        'text' => "Text input",
                        'password' => "Password input",
                        'checkbox' => "Checkbox input",
                        'select' => "Select input",
                        'email' => "Email input",
                        'file' => "File input",
                        'hidden' => "hidden input",
                        'card' => "Infocard view",
                        'ip' => "Remote Addrs (IPV4/IPV6)",
                        'location' => "Lat. Long. (location)",
                        'face-cam' => "Face Cam (selfie)",
                    ]
                ],
                '_key_value' => [
                    'options' => [
                        'add_action_label' => 'Add option',
                        'key_placeholder' => 'Insert a key',
                        'value_placeholder' => 'Insert a value'
                    ]
                ],
                '_options' => [
                    'ai_auto_verify' => ['Disable', 'Enable']
                ]
            ],
            'placeholder' => [
                'label' => 'Label of input',
                'type' => 'Type of input',
                'name' => 'Name of input',
                'placeholder' => 'Placeholder for input',
                'value' => 'Default value',
                'mask' => 'Mask for input',
                'required' => 'Is required',
                'options' => 'Select options',
                'ai_auto_verify' => 'AI Auto verify',
                'html' => 'HTML code'
            ]
        ]
    ]
];
