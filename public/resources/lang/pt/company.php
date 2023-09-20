<?php
// resources/lang/pt/company.php
return [
    'data' => [
        'data'              => 'Dados Empresa',
        'data_edit'         => 'Editar Dados Empresa',
        'data_full'         => 'Dados da Empresa',
        'name'              => 'Nome Empresa',
        'acronym'           => 'Acrónimo',
        'address'           => 'Morada',
        'phone'             => 'Telefone',
        'website'           => 'Website',
        'nif'               => 'NIF',
        'country'           => 'País',
        'activity'          => 'Atividade',
        'manager'           => [
            'data'          => 'Dados Gestor',
            'manager'       => 'Gestor',
            'name'          => 'Nome',
            'email'         => 'E-mail',
            'phone'         => 'Telefone',
            'position'      => 'Cargo',

        ],
        'legalrep'          => [
            'data'          => 'Dados Representante Legal',
            'legalrep'      => 'Representante Legal',
            'name'          => 'Nome',
            'email'         => 'E-mail',
            'phone'         => 'Telefone',
            'position'      => 'Cargo',
        ],
        'colab'            => [
            'data'          => 'Dados Colaborador',
            'colab'        => 'Colaborador',
            'name'          => 'Nome',
            'email'         => 'E-mail',
            'phone'         => 'Telefone',
            'position'      => 'Cargo',
            'yearsExp'      => 'Anos de Experiência',
            'training'      => 'Formação',
            'cv'            => 'CV',
        ],
    ],
    'messages' => [
        'edit'              => [
            'company'       => 'Editar dados da empresa',
            'manager'       => 'Editar dados do gestor',
            'legalrep'      => 'Editar dados do representante legal',
            'colab'         => 'Editar dados do colaborador',
            'short'         =>  [
                'company'       => 'Editar empresa',
                'manager'       => 'Editar gestor',
                'legalrep'      => 'Editar representante legal',
                'colab'         => 'Editar colaborador',
            ],

        ],
        'nif' => [
            'invalid'       => 'O NIF introduzido inválido',
            'notunique'     => 'O NIF introduzido já existe',
        ],
        'success'           => 'Empresa registada com sucesso!',
        'edit_success'      => 'Dados da empresa editados com sucesso!',
        'error'             => 'Ocorreu um erro ao registar a empresa!',
        'edit_error'        => 'Ocorreu um erro ao editar os dados da empresa!',
        'request'           => [
            'gestor'        => [
                'error'     => [
                    'not_active'   => 'O utilizador não está ativo',
                    'exists'       => 'O utilizador já é gestor',

                ],
                'success_quick'   => 'O utilizador é agora gestor',
                'success'         => 'O utilizador é agora gestor e irá receber um email para confirmar a conta',
            ],
            'rep'           => [
                'error'     => [
                    'not_active'   => 'O utilizador não está ativo',
                    'exists'       => 'O utilizador já é representante legal',

                ],
                'success_quick'   => 'O utilizador é agora representante legal',
                'success'         => 'O utilizador é agora representante legal e irá receber um email para confirmar a conta',
            ],
            'colab'         => [
                'error'     => [
                    'not_active'   => 'O utilizador não está ativo',
                    'exists'       => 'O utilizador já é colaborador',

                ],
                'success_quick'   => 'O utilizador é agora colaborador',
                'success'         => 'O utilizador é agora colaborador e irá receber um email para confirmar a conta',
            ],

        ],
        'deactivate'        => [
            'error'         => [
                'self'              => 'Não pode desativar a sua própria conta',
                'same_state'        => 'A conta já se encontra desativada',
                'last_gestor'       => 'Não pode desativar a conta do último gestor',
                'last_rep'          => 'Não pode desativar a conta do último representante legal',
                'not_same_company'  => 'Não pode desativar a conta de um utilizador de outra empresa',
            ],
            'success'               => [
                'false'             => 'Conta desativada com sucesso',
                'true'              => 'Conta ativada com sucesso',
            ]

        ],
        // deactivate.error.self
        // deactivate.error.same_state
        // deactivate.error.last_gestor
        // deactivate.error.last_rep
        // deactivate.success
    ]
];