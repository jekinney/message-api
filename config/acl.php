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
        ['slug' => 'owner', 'display_name' => 'Owner', 'description' => 'Owner of the site with all permissions'],
        ['slug' => 'member', 'display_name' => 'Member', 'description' => 'Member and contributor to the site'],
    ],
    /**
     * List out basic permissions here.
     * No interface or endpoints to
     * update or create permissions
     */
    'permissions' => [
        // Public facing permissions
        ['slug' => 'access-messages', 'display_name' => 'Access Messages', 'description' => 'Able to access messages', 'is_admin' => false],
        ['slug' => 'create-messages', 'display_name' => 'Create Messages', 'description' => 'Able to create new messages', 'is_admin' => false],
        ['slug' => 'update-messages', 'display_name' => 'Update Messages', 'description' => 'Able to update own messages', 'is_admin' => false],
        ['slug' => 'remove-messages', 'display_name' => 'Remove Messages', 'description' => 'Able to remove own messages', 'is_admin' => false],
        ['slug' => 'reinstate-messages', 'display_name' => 'Reinstate Messages', 'description' => 'Able to reinstate own messages', 'is_admin' => false],
        // Admin access to dashboard
        // Messages
        ['slug' => 'admin-access-messages', 'display_name' => 'Admin Access Messages', 'description' => 'Able to access all messages', 'is_admin' => true],
        ['slug' => 'admin-update-messages', 'display_name' => 'Admin Update Messages', 'description' => 'Able to update any messages', 'is_admin' => true],
        ['slug' => 'remove-messages', 'display_name' => 'Remove Messages', 'description' => 'Able to remove any messages', 'is_admin' => true],
        ['slug' => 'reinstate-messages', 'display_name' => 'Reinstate Messages', 'description' => 'Able to reinstate any messages', 'is_admin' => true],
        ['slug' => 'perm-remove-messages', 'display_name' => 'Permanently Remove Messages', 'description' => 'Able to permanently remove any messages', 'is_admin' => true],
        // Roles (permissions are implied)
        ['slug' => 'admin-access-roles', 'display_name' => 'Admin Access Roles', 'description' => 'Able to access all roles', 'is_admin' => true],
        ['slug' => 'create-roles', 'display_name' => 'Create Roles', 'description' => 'Able to create new messages', 'is_admin' => true],
        ['slug' => 'admin-update-roles', 'display_name' => 'Admin Update Roles', 'description' => 'Able to update any roles', 'is_admin' => true],
        ['slug' => 'remove-roles', 'display_name' => 'Remove Roles', 'description' => 'Able to remove any roles', 'is_admin' => true],
        ['slug' => 'reinstate-roles', 'display_name' => 'Reinstate Roles', 'description' => 'Able to reinstate any roles', 'is_admin' => true],
        ['slug' => 'perm-remove-roles', 'display_name' => 'Permanently Remove Roles', 'description' => 'Able to permanently remove any roles', 'is_admin' => true],
    ],
];
