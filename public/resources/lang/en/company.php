<?php
// resources/lang/en/company.php
return [
    'data' => [
        'data'              => 'Company Details',
        'data_edit'         => 'Edit Company Details',
        'data_full'         => 'Company Details',
        'name'              => 'Company Name',
        'acronym'           => 'Acronym',
        'address'           => 'Address',
        'phone'             => 'Phone',
        'website'           => 'Website',
        'nif'               => 'Fiscal Number',
        'country'           => 'Country',
        'activity'          => 'Activity',
        'manager'           => [
            'data'          => 'Manager Details',
            'manager'       => 'Manager',
            'name'          => 'Name',
            'email'         => 'E-mail',
            'phone'         => 'Phone',
            'position'      => 'Position',

        ],
        'legalrep'          => [
            'data'          => 'Legal Representative Details',
            'legalrep'      => 'Legal Representative',    
            'name'          => 'Name',
            'email'         => 'E-mail',
            'phone'         => 'Phone',
            'position'      => 'Position',
        ],
        'colab'             => [
            'data'          => 'Collaborator Details',
            'colab'        => 'Collaborator',
            'name'          => 'Name',
            'email'         => 'E-mail',
            'phone'         => 'Phone',
            'position'      => 'Position',
            'yearsExp'      => 'Years of Experience',
            'training'      => 'Training',
            'cv'            => 'CV',
        ]
    ],

    'messages' => [
        'edit'              => [
            'company'           => 'Edit company details',
            'manager'           => 'Edit manager details',
            'legalrep'          => 'Edit legal representative details',
            'colab'             => 'Edit collaborator details',
            'short'             =>  [
                'company'       => 'Edit company',
                'manager'       => 'Edit manager',
                'legalrep'      => 'Edit legal representative',
                'colab'         => 'Edit collaborator',
            ],

        ],
        'nif' => [
            'invalid'       =>    'Invalid Fiscal Number',
            'notunique'     =>   'Fiscal Number already exists',
        ],
        'success'           => 'Company registered successfully!',
        'edit_success'      => 'Company details edited successfully!',
        'error'             => 'An error occurred while registering the company!',
        'edit_error'        => 'An error occurred while editing the company details!',
        'request'           => [
            'gestor'        => [
                'error'     => [
                    'not_active'   => 'The user is not active',
                    'exists'       => 'The user already is a manager',

                ],
                'success_quick'   => 'The user is now a manager',
                'success'         => 'The user is now a manager and will receive an email to confirm the account',
            ],
            'rep'           => [
                'error'     => [
                    'not_active'   => 'The user is not active',
                    'exists'       => 'The user already is a legal representative',

                ],
                'success_quick'   => 'The user is now a legal representative',
                'success'         => 'The user is now a legal representative and will receive an email to confirm the account',
            ],
            'colab'         => [
                'error'     => [
                    'not_active'   => 'The user is not active',
                    'exists'       => 'The user already is a collaborator',

                ],
                'success_quick'   => 'The user is now a collaborator',
                'success'         => 'The user is now a collaborator and will receive an email to confirm the account',
            ],
        ],
        'deactivate'        => [
            'error'         => [
                'self'              => 'You cannot deactivate yourself',
                'same_state'        => 'The user is already deactivated',
                'last_gestor'       => 'The company must have at least one manager',
                'last_rep'          => 'The company must have at least one legal representative',
                'not_same_company'  => 'The user does not belong to the company',
            ],
            'success'           => [
                'false'         => 'The user is now deactivated',
                'true'          => 'The user is now activated',
            ],
        ],

    ]
];