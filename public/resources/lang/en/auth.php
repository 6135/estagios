<?php
// resources/lang/en/auth.php

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
    'already' => 'I already have an account',
    'already.enter' => 'Login',
    'failed' => 'These credentials do not match our records.',
    'toconfirm' => 'Your account is not confirmed. Please check your email.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'success' => 'Authentication successful!',
    'role' => [
        'switch' => [
            'success'       => 'Role changed successfully!',
            'error'         => 'Error changing role!',
            'missing'       => 'Role not found!',
            'invalid'       => 'Invalid role!',
            'unauthorized'  => 'Unauthorized to change user role!',
            'unauthorized2' => 'Unauthorized to change your role!',
            'notassigned'   => 'Role not assigned!',
        ]
        ],
    'login' => 'login',
    'register' => [
        'company'           => 'Register company',
        'company_email'     => 'Company email',
        'success'           => 'User registered successfully! Check your email to activate the account!',
        'check'             => 'Check your email to activate the account!',
        'error'             => 'Error registering user!',
        'invalid'           => 'Invalid user!',
        'unauthorized'      => 'Unauthorized to register user!',
        'notunique'         => 'This user already exists.',
        'password' => [
            'passwordconfirmation' => 'Confirm password',
            'password'      => 'Password',
            'confirm'       => 'Confirm password',
            'mismatch'      => 'Passwords do not match!',
            'length'        => 'Password must be at least 8 characters!',
        ],
        'email' => [
            'invalid'       => 'Email is not valid!',
            'missing'       => 'Email is required!',
            'unique'        => 'Email already exists!',
            
        ],
        'name' => [
            'missing'       => 'Name is required!',
        ],
        'resend' => [
            'success'       => 'Activation email resent successfully!',
            'error'         => 'Error resending activation email!',
        ],
        'new' => [
            'company'       => 'Register company',
            'create'        => 'Create',
            'nif'           => 'Fiscal number',
            'create_company' => 'Create company',

        ]

    ],
    'reset' => [
        'success'           => 'Password reset successfully!',
        'error'             => 'Error resetting password!',
        'invalid'           => 'Invalid password reset!',
        'unauthorized'      => 'Unauthorized to reset password!',
        'email' => [
            'missing'       => 'Email is required!',
            'envelope'      => 'Password reset',
            
        ],
        'password' => [
            'mismatch'      => 'Passwords do not match!',
            'length'        => 'Password must be at least 8 characters!',
        ],
    ],
    'change' => [
        'success'           => 'Password changed successfully!',
        'error'             => 'Error changing password!',
        'invalid'           => 'Invalid password change!',
        'forgot'            => 'Recover password',
        'password' => [
            'mismatch'      => 'Passwords do not match!',
            'length'        => 'Password must be at least 8 characters!',
        ],
    ]
    
];
