<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

/**
 * The permission checkboxes the Employee screen offers, one group per admin
 * module. Re-runnable: rows are matched by name, so seeding twice changes
 * nothing, and permissions whose features are gone are swept out.
 */
class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Gone with the features that used them: palikas and businesses have
        // no admin screens any more, and "blog:" was never what the code
        // checked — posts answer to "post:".
        Permission::where('name', 'LIKE', 'palika:%')
            ->orWhere('name', 'LIKE', 'business:%')
            ->orWhere('name', 'LIKE', 'blog:%')
            ->delete();

        // One group per module, the four usual actions each. "subcategory"
        // covers every level below the top of the menu tree. Reordering
        // (organizations, the menu tree) rides on the group's "edit".
        $groups = [
            'organization',
            'category',
            'subcategory',
            'post',
            'banners',
            'notice',
            'attachment',
            'page',
            'user',
        ];

        foreach ($groups as $group) {
            foreach (['view', 'create', 'edit', 'delete'] as $action) {
                Permission::firstOrCreate([
                    'name' => "{$group}:{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Site settings are a single row that is only ever edited.
        Permission::firstOrCreate(['name' => 'cms:edit', 'guard_name' => 'web']);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
