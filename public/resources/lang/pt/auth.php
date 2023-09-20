<?php
declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'already' => 'Já tenho conta',
    'already.enter' => 'Entrar',
    'failed'                => 'Utilizador ou password errados.',
    'throttle'              => 'Muitas tentativas falhadas. Tente novamente daqui a :seconds segundos.',
    'success'               => 'Autenticação bem sucedida!',
    'toconfirm'             => 'A sua conta não está confirmada. Por favor verifique o seu email.',
    'role' => [
        'switch' => [
            'success'       => 'Papel alterado com sucesso!',
            'error'         => 'Erro ao alterar papel!',
            'missing'       => 'Papel não encontrado!',
            'invalid'       => 'Papel inválido!',
            'unauthorized'  => 'Não tem permissões para alterar o papel do utilizador!',
            'unauthorized2' => 'Não tem permissões para alterar o seu papel!',
            'notassigned'   => 'Não tem o papel atribuído!',
        ]
    ],
    'login' => 'login',
    'register' => [
        'company'           => 'Registar Empresa',
        'company_email'     => 'E-mail empresa',
        'success'       => 'Utilizador registado com sucesso! Confirme o seu email.',
        'check'         => 'Verifique o seu email para ativar a conta!',
        'error'         => 'Erro ao registar utilizador!',
        'invalid'       => 'Utilizador inválido!',
        'unauthorized'  => 'Não tem permissões para registar utilizador!',
        'notunique'     => 'Este utilizador já existe.',
        'password' => [
            'passwordconfirmation' => 'Confirmar password',
            'password'  => 'Password',
            'confirm'   => 'Confirmar password',
            'mismatch'  => 'As passwords não coincidem!',
            'length'    => 'A password deve ter pelo menos 8 caracteres!',
        ],
        'email' => [
            'email'     => 'Email',
            'invalid'   => 'O email não é válido!',
            'missing'   => 'O email é obrigatório!',
            'unique'    => 'O email já existe!',
        ],
        'name' => [
            'missing'   => 'O nome é obrigatório!',
        ],
        'resend' => [
            'success'   => 'Email de ativação reenviado com sucesso!',
            'error'     => 'Erro ao reenviar email de ativação!',
        ],
        'new' => [
            'company'   => 'Registar empresa',
            'create'    => 'Criar',
            'create_company' => 'Criar empresa',
            'nif'       => 'Numero de identificação fiscal',
        ]
    ],

    'reset' => [
        'success'       => 'Password alterada com sucesso!',
        'error'         => 'Erro ao alterar password!',
        'invalid'       => 'Alteração de password inválida!',
        'forgot'        => 'Recuperar password',
        'unauthorized'  => 'Não tem permissões para alterar a password!',
        'email' => [
            'missing'   => 'O email é obrigatório!',
            'envelope'  => 'Repor a password',
        ],
        'password' => [
            'mismatch'  => 'As passwords não coincidem!',
            'length'    => 'A password deve ter pelo menos 8 caracteres!',
        ],
    ],
    'change' => [
        'success'       => 'Password alterada com sucesso!',
        'error'         => 'Erro ao alterar password!',
        'invalid'       => 'Alteração de password inválida!',
        'password' => [
            'mismatch'  => 'As passwords não coincidem!',
            'length'    => 'A password deve ter pelo menos 8 caracteres!',
        ],
    ],
    'confirmation' => [
        'success'       => 'Conta confirmada com sucesso.',
        'error'         => 'Erro ao confirmar conta.',
    ]
    
];