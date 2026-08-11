<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Wards are gone — everything is a Palika now, so the ward:* permissions
     * fold into the palika:* ones. Three palika permissions already exist
     * (view/edit/delete), so those grants get moved across rather than renamed.
     *
     * @return void
     */
    public function up()
    {
        $map = [
            'ward:view' => 'palika:view',
            'ward:edit' => 'palika:edit',
            'ward:delete' => 'palika:delete',
            'ward:reorder' => 'palika:reorder',
            'ward:category' => 'palika:category',
        ];

        foreach ($map as $old => $new) {
            $oldId = DB::table('permissions')->where('name', $old)->where('guard_name', 'web')->value('id');

            if (! $oldId) {
                continue;
            }

            $newId = DB::table('permissions')->where('name', $new)->where('guard_name', 'web')->value('id');

            if (! $newId) {
                DB::table('permissions')->where('id', $oldId)->update(['name' => $new]);
                continue;
            }

            $this->moveGrants($oldId, $newId);
            DB::table('permissions')->where('id', $oldId)->delete();
        }

        // "Add Palika" was never a permission of its own — wards were the only
        // thing you could create. Anyone allowed to edit a palika gets it.
        $createId = $this->ensurePermission('palika:create');
        $editId = DB::table('permissions')->where('name', 'palika:edit')->where('guard_name', 'web')->value('id');

        if ($editId) {
            $this->copyGrants($editId, $createId);
        }

        // Anything still referencing a ward permission would silently deny.
        foreach (array_keys($map) as $old) {
            $this->ensurePermission(str_replace('ward:', 'palika:', $old));
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // One-way: the ward/palika split can't be reconstructed once merged.
    }

    /** Create the permission when it is missing and return its id. */
    protected function ensurePermission($name)
    {
        $id = DB::table('permissions')->where('name', $name)->where('guard_name', 'web')->value('id');

        if ($id) {
            return $id;
        }

        return DB::table('permissions')->insertGetId([
            'name' => $name,
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /** Re-point every role/user grant from one permission to another. */
    protected function moveGrants($fromId, $toId)
    {
        $this->copyGrants($fromId, $toId);

        DB::table('role_has_permissions')->where('permission_id', $fromId)->delete();
        DB::table('model_has_permissions')->where('permission_id', $fromId)->delete();
    }

    /** Grant $toId to every role/user that already holds $fromId. */
    protected function copyGrants($fromId, $toId)
    {
        $roleIds = DB::table('role_has_permissions')->where('permission_id', $fromId)->pluck('role_id');

        foreach ($roleIds as $roleId) {
            $exists = DB::table('role_has_permissions')
                ->where('permission_id', $toId)
                ->where('role_id', $roleId)
                ->exists();

            if (! $exists) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $toId,
                    'role_id' => $roleId,
                ]);
            }
        }

        $models = DB::table('model_has_permissions')->where('permission_id', $fromId)->get();

        foreach ($models as $model) {
            $exists = DB::table('model_has_permissions')
                ->where('permission_id', $toId)
                ->where('model_type', $model->model_type)
                ->where('model_id', $model->model_id)
                ->exists();

            if (! $exists) {
                DB::table('model_has_permissions')->insert([
                    'permission_id' => $toId,
                    'model_type' => $model->model_type,
                    'model_id' => $model->model_id,
                ]);
            }
        }
    }
};
