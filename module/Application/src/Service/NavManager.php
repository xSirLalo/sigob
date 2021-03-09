<?php
namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Laminas\Authentication\Authentication
     */
    private $authService;

    /**
     * Url view helper.
     * @var Laminas\View\Helper\Url
     */
    private $urlHelper;

    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper, $rbacManager)
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];

        $items[] = [
            'id' => 'home',
            'label' => 'Home',
            'link'  => $url('home'),
            'icon' => 'feather icon-home"'
        ];

        $items[] = [
            'id' => 'about',
            'label' => 'About',
            'icon' => 'feather icon-info',
            'link'  => $url('about')
        ];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login'),
            ];
        } else {

            // Determine which items must be displayed in Admin dropdown.
            $bibliotecaDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'catastro.manage')) {
                $bibliotecaDropdownItems[] = [
                            'id' => 'biblioteca',
                            'label' => 'Biblioteca',
                            'link'  => $url('biblioteca')
                        ];

                $bibliotecaDropdownItems[] = [
                            'id' => 'categoria',
                            'label' => 'Categoria',
                            'link'  => $url('categoria')
                        ];
            }

            if (count($bibliotecaDropdownItems)!=0) {
                $items[] = [
                    'header'  => "Catastro",
                    'link'  => ""
                ];

                $items[] = [
                    'id' => 'contribuyente',
                    'label' => 'Contribuyentes',
                    'icon' => 'feather icon-users',
                    'link'  => $url('contribuyente')
                ];

                $items[] = [
                    'id' => 'predio',
                    'label' => 'Predios',
                    'icon' => 'feather icon-codepen',
                    'link'  => $url('predio')
                ];

                $items[] = [
                    'id' => 'bibliotecas',
                    'label' => 'Bibliotecas',
                    'icon' => 'feather icon-menu"',
                    'dropdown' => $bibliotecaDropdownItems
                ];
            }

            // Determine which items must be displayed in Admin dropdown.
            $aportacionDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'catastro.manage')) {
                $aportacionDropdownItems[] = [
                            'id' => 'aportacion',
                            'label' => 'Aportacion',
                            'link'  => $url('aportacion')
                        ];

                $aportacionDropdownItems[] = [
                            'id' => 'validacion',
                            'label' => 'Validacion',
                            'link'  => $url('aportacion/validacion')
                        ];
            }

            if (count($aportacionDropdownItems)!=0) {
                $items[] = [
                    'id' => 'aportaciones',
                    'label' => 'Aportaciones',
                    'icon' => 'feather icon-menu"',
                    'dropdown' => $aportacionDropdownItems
                ];
            }

            // Determine which items must be displayed in Admin dropdown.
            $adminDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'users',
                            'label' => 'Manage Users',
                            'link' => $url('users')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'permission.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'permissions',
                            'label' => 'Manage Permissions',
                            'link' => $url('permissions')
                        ];
            }

            if ($this->rbacManager->isGranted(null, 'role.manage')) {
                $adminDropdownItems[] = [
                            'id' => 'roles',
                            'label' => 'Manage Roles',
                            'link' => $url('roles')
                        ];
            }

            if (count($adminDropdownItems)!=0) {
                $items[] = [
                    'header'  => "Administración",
                    'link'  => ""
                ];

                $items[] = [
                    'id' => 'admin',
                    'label' => 'Admin',
                    'icon' => 'feather icon-menu"',
                    'dropdown' => $adminDropdownItems
                ];
            }

            $items[] = [
                'header'  => "Cuenta",
                'link'  => ""
            ];

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'icon' => '"',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => 'Settings',
                        'link' => $url('application', ['action'=>'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Sign out',
                        'link' => $url('logout')
                    ],
                ]
            ];
        }

        return $items;
    }
}
