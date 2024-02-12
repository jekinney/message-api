<?php

/**
 * Set up seeding data for roles and permission models
 *
 * ['slug' => '', 'display_name' => '', 'description' => ''],
 */
return [
    /**
     * Hard coded roles for default use.
     * Roles will have crud interface
     */
    'roles' => [
        ['slug' => 'owner', 'display_name' => 'Owner', 'description' => 'Owner of the site with all permissions.'],
        ['slug' => 'member', 'display_name' => 'Member', 'description' => 'Member and contributor to message side of site.'],
        ['slug' => 'author', 'display_name' => 'Author', 'description' => 'Author and contributor to the article side of the site.'],
    ],
    /**
     * List out basic permissions here.
     * No interface or endpoints to
     * update or create permissions
     */
    'permissions' => [
        // Auth user permissions
        ['slug' => 'access-messages', 'display_name' => 'Access Messages', 'description' => 'Able to access messages', 'is_admin' => false, 'for' => 'member'],
        ['slug' => 'create-messages', 'display_name' => 'Create Messages', 'description' => 'Able to create new messages', 'is_admin' => false, 'for' => 'member'],
        ['slug' => 'update-messages', 'display_name' => 'Update Messages', 'description' => 'Able to update own messages', 'is_admin' => false, 'for' => 'member'],
        ['slug' => 'remove-messages', 'display_name' => 'Remove Messages', 'description' => 'Able to remove own messages', 'is_admin' => false, 'for' => 'member'],
        ['slug' => 'access-articles', 'display_name' => 'Access Articles', 'description' => 'Able to access articles', 'is_admin' => false, 'for' => 'author'],
        ['slug' => 'create-articles', 'display_name' => 'Create Articles', 'description' => 'Able to create new articles', 'is_admin' => false, 'for' => 'author'],
        ['slug' => 'update-articles', 'display_name' => 'Update Articles', 'description' => 'Able to update own articles', 'is_admin' => false, 'for' => 'author'],
        ['slug' => 'remove-articles', 'display_name' => 'Remove Articles', 'description' => 'Able to remove own articles', 'is_admin' => false, 'for' => 'author'],

        // Admin access to dashboard
        // Messages
        ['slug' => 'admin-access-messages', 'display_name' => 'Admin Access Messages', 'description' => 'Able to access all messages', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-update-messages', 'display_name' => 'Admin Update Messages', 'description' => 'Able to update any messages', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-remove-messages', 'display_name' => 'Admin Remove Messages', 'description' => 'Able to remove any messages', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-delete-messages', 'display_name' => 'Admin Delete Messages', 'description' => 'Able to permanently delete any message', 'is_admin' => true, 'for' => null],
        // Roles (permissions are implied)
        ['slug' => 'admin-access-roles', 'display_name' => 'Admin Access Roles', 'description' => 'Able to access all roles', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-create-roles', 'display_name' => 'Admin Create Roles', 'description' => 'Able to create new messages', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-update-roles', 'display_name' => 'Admin Update Roles', 'description' => 'Able to update any roles', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-remove-roles', 'display_name' => 'Admin Remove Roles', 'description' => 'Able to remove any roles', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-delete-roles', 'display_name' => 'Admin Delete Roles', 'description' => 'Able to permanently delete any role', 'is_admin' => true, 'for' => null],
        // Articles
        ['slug' => 'admin-access-articles', 'display_name' => 'Admin Access Articles', 'description' => 'Able to access articles', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-create-articles', 'display_name' => 'Admin Create Articles', 'description' => 'Able to create new articles', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-update-articles', 'display_name' => 'Admin Update Articles', 'description' => 'Able to update own articles', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-remove-articles', 'display_name' => 'Admin Remove Articles', 'description' => 'Able to remove own articles', 'is_admin' => true, 'for' => null],
        ['slug' => 'admin-delete-articles', 'display_name' => 'Admin Delete Articles', 'description' => 'Able to permanently delete any article', 'is_admin' => true, 'for' => null],
    ],
];
