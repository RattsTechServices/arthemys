<?php
// lang/pt_BR/manager.php

return [
    'pages' => [
        'dashboard' => [
            'actions' => [
                'label' => [
                    'configurations' => 'Configurações'
                ],
                'form' => [
                    'input' => [
                        'title' => 'Título',
                        'description' => 'Descrição',
                        'logo_light' => 'Logo claro',
                        'logo_dark' => 'Logo escuro',
                        'favicon' => 'Favicon',
                        'ia_detect_object_driver' => 'Selecionar driver de detecção de rosto por IA'
                    ],
                    'placeholder' => [
                        'title' => 'Título padrão do sistema',
                        'description' => 'Descrição padrão do sistema',
                        'logo_light' => 'Logo padrão do aplicativo (claro)',
                        'logo_dark' => 'Logo padrão do aplicativo (escuro)',
                        'favicon' => 'Favicon padrão do aplicativo',
                        'ia_detect_object_driver' => 'Selecionar driver de detecção de rosto por IA'
                    ]
                ],
            ]
        ]
    ],
    /******** Traduções dos Itens do Menu ***********/
    'menu_applications' => [
        "single" => "Aplicação",
        "plural" => "Aplicações",
    ],
    'menu_registers' => [
        "single" => "Registro",
        "plural" => "Registros",
    ],
    'menu_inputs' => [
        "single" => "Entrada",
        "plural" => "Entradas",
    ],
    'menu_steps' => [
        "single" => "Etapa",
        "plural" => "Etapas",
    ],
    'menu_updater' => [
        "single" => "Atualizador",
        "plural" => "Atualizações",
    ],
    'menu_themes' => [
        "single" => "Tema",
        "plural" => "Temas",
    ],
    'menu_users' => [
        "single" => "Usuário",
        "plural" => "Usuários",
    ],
    /******* Traduções de Itens de Ação **********/
    'label_applications' => [
        "single" => "Aplicação",
        "plural" => "Aplicações",
    ],
    'label_registers' => [
        "single" => "Registro da Aplicação",
        "plural" => "Registros da Aplicação",
    ],
    'label_inputs' => [
        "single" => "Entrada de Etapa",
        "plural" => "Entradas de Etapa",
    ],
    'label_steps' => [
        "single" => "Etapa de Registro",
        "plural" => "Etapas de Registro",
    ],
    'label_updater' => [
        "single" => "Atualização de Software",
        "plural" => "Atualizações de Software",
    ],
    'label_themes' => [
        "single" => "Tema / Plugin",
        "plural" => "Temas e Plugins",
    ],
    'label_users' => [
        "single" => "Usuário do Sistema",
        "plural" => "Usuários do Sistema",
    ],
    /******* Traduções de Tabelas e Formulários **********/
    'users_resources' => [
        'table' => [
            'id' => '#ID',
            'name' => "Nome",
            'email' => "E-mail",
            'phone' => "Telefone",
            'created_at' => "Criado em",
            "_defaults" => [
                'phone' => "vazio"
            ],
            "_masks" => [
                'created_at' => "Y-m-d H:i"
            ]
        ],
        'form' => [
            'input' => [
                'name' => "Nome",
                'email' => "E-mail",
                'phone' => "Telefone",
                'password' => "Senha",
                'created_at' => "Criado em"
            ],
            'placeholder' => [
                'name' => "Nome completo",
                'email' => "email@dominio.com",
                'phone' => "+55 (85) 99999-9999",
                'password' => "8 a 16 caracteres com números e letras",
            ],
            'mask' => [
                'phone' => '+99 (99) 99999-9999'
            ]
        ]
    ],
    'theme_manager_resources' => [
        'table' => [
            'id' => '#ID',
            'is_active' => 'Ativo',
            'title' => 'Título',
            'slug' => 'Slug',
            'namespace' => 'Namespace',
            'created_at' => 'Criado em',
            '_masks' => [
                'created_at' => 'Y-m-d H:i'
            ]
        ],
        'form' => [
            'action' => [
                'upload' => 'Carregar Tema'
            ],
            'input' => [
                'file' => 'Upload de Arquivo',
            ],
            'placeholder' => [
                'file' => 'Anexar um arquivo .zip do seu tema, tamanho máximo de 100MB'
            ]
        ],
        'notifications' => [
            'file' => [
                'success' => [
                    'title' => 'Tema carregado com sucesso',
                ],
                'error' => [
                    'title' => 'Ocorreu um erro!'
                ]
            ]
        ]
    ],
    'software_update_resources' => [
        'table' => [
            'id' => '#ID',
            'version' => 'Versão',
            'repository' => 'Repositório',
            'artefact' => 'Artefato',
            'size' => 'Tamanho',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
            '_masks' => [
                'created_at' => 'Y-m-d H:i',
                'updated_at' => 'Y-m-d H:i'
            ]
        ]
    ],
    'register_step_resource' => [
        'table' => [
            'id' => '#ID',
            'title' => 'Título',
            'status' => 'Status',
            'client_application' => 'Aplicação',
            'register_inputs' => 'Entradas de Registro',
            'created_at' => 'Data de criação',
            '_tooltips' => [
                'title' => 'Título da etapa. Este item pode ser modificado na ação de edição.',
                'status' => 'Status da etapa. Define se este item está Habilitado ou Desabilitado.',
                'client_application' => 'ID de referência da aplicação',
                'register_inputs' => 'Número de entradas neste item',
                'created_at' => 'Data de criação do item'
            ]
        ],
        'form' => [
            'input' => [
                'title' => 'Título para etapa',
                'description' => 'Descrição',
                'step' => 'Número da etapa',
                'identify' => 'Slug ID',
                'client_application_id' => 'Selecionar aplicação',
                'status' => 'Status',
                '_select' => [
                    'status' => ['Negar', 'Permitir']
                ]
            ],
            'placeholder' => [
                'title' => 'adicione um título para a etapa',
                'description' => 'adicione uma descrição para a etapa',
                'step' => 'número da etapa',
                'identify' => 'slug ID para a Etapa',
                'client_application_id' => 'Selecione a aplicação para usar na etapa',
                'status' => 'Selecione o status'
            ]
        ]
    ],
    'register_input_resource' => [
        'table' => [
            'id' => '#ID',
            'register_step' => 'Etapa de Registro',
            'label' => 'Rótulo',
            'type' => 'Tipo de Entrada',
            'required' => 'Item obrigatório',
            'is_client_register_collection' => 'Pré-formulário',
            'created_at' => 'Criado em'
        ],
        'form' => [
            'input' => [
                'label' => 'Rótulo',
                'register_step_id' => 'Etapa de registro',
                'client_application_id' => 'Aplicação do cliente',
                'type' => 'Tipo',
                'name' => 'Nome',
                'placeholder' => 'Placeholder',
                'value' => 'Valor',
                'mask' => 'Máscara',
                'required' => 'Obrigatório',
                'options' => 'Opções de seleção',
                'ai_auto_verify' => 'Verificação automática IA',
                'html' => 'Código HTML',
                '_select' => [
                    'type' => [
                        'text' => "Entrada de texto",
                        'password' => "Entrada de senha",
                        'checkbox' => "Entrada de checkbox",
                        'select' => "Entrada de seleção",
                        'email' => "Entrada de e-mail",
                        'file' => "Entrada de arquivo",
                        'hidden' => "Entrada oculta",
                        'card' => "Visualização de infocartão",
                        'ip' => "Endereço Remoto (IPV4/IPV6)",
                        'location' => "Lat. Long. (localização)",
                        'face-cam' => "Câmera Facial (selfie)",
                    ]
                ],
                '_key_value' => [
                    'options' => [
                        'add_action_label' => 'Adicionar opção',
                        'key_placeholder' => 'Insira uma chave',
                        'value_placeholder' => 'Insira um valor'
                    ]
                ],
                '_options' => [
                    'ai_auto_verify' => ['Desabilitado', 'Habilitado']
                ]
            ],
            'placeholder' => [
                'label' => 'Rótulo da entrada',
                'type' => 'Tipo de entrada',
                'name' => 'Nome da entrada',
                'placeholder' => 'Placeholder para entrada',
                'value' => 'Valor padrão',
                'mask' => 'Máscara para entrada',
                'required' => 'É obrigatório',
                'options' => 'Opções de seleção',
                'ai_auto_verify' => 'Verificação automática IA',
                'html' => 'Código HTML'
            ]
        ]
    ],
    'client_register_collection_resource' => [
        'table' => [
            'id' => '#ID',
            'application' => 'Aplicação',
            'precollected' => 'Dados pré-coletados',
            'itens' => 'Itens coletados',
            'created_at' => 'Data de registro',
            '_defaults' => [
                'application' => 'Aplicação excluída',
                'precollected' => 'Sem dados'
            ],
            '_descriptions' => [
                'application' => 'Descrição desconhecida'
            ],
            '_mask' => [
                'created_at' => 'Y-m-d H:i'
            ]
        ],
        'form' => [
            'input' => [
                'client_application_id' => 'Aplicação do cliente',
                'collected' => 'Dados coletados'
            ]
        ]
    ],
    'client_application_resource' => [
        'table' => [
            'id' => '#ID',
            'logo_light' => 'Logo padrão',
            'title' => 'Título ou rótulo',
            'slug_title' => 'Slug do título',
            'user' => 'Usuário',
            'created_at' => 'Criado em',
            '_mask' => [
                'created_at' => 'Y-m-d H:i'
            ]
        ],
        'form' => [
            'input' => [
                'user_id' => 'Usuário',
                'title' => 'Título ou rótulo',
                'slug_title' => 'Slug',
                'description' => 'Descrição',
                'callback' => 'URL de callback',
                'url' => 'URL',
                'webhookie' => 'Webhookie',
                'status' => 'Status',
                'condition' => 'Condição'
            ],
            'placeholder' => [
                'user_id' => 'Selecione o usuário',
                'title' => 'Título ou rótulo da aplicação',
                'slug_title' => 'nao-use-espacos',
                'description' => 'Coloque uma descrição curta',
                'callback' => 'URL de callback',
                'url' => 'https://dominio.com.br',
                'webhookie' => 'https://dominio.com.br/api/webhookie',
                'status' => 'Status da aplicação',
                'condition' => 'Condição da aplicação'
            ]
        ]
    ]
];
