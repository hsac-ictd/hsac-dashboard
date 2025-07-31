<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_affirmance::rate","view_any_affirmance::rate","create_affirmance::rate","update_affirmance::rate","restore_affirmance::rate","restore_any_affirmance::rate","replicate_affirmance::rate","reorder_affirmance::rate","delete_affirmance::rate","delete_any_affirmance::rate","force_delete_affirmance::rate","force_delete_any_affirmance::rate","import_affirmance::rate","export_affirmance::rate","view_appealed::case","view_any_appealed::case","create_appealed::case","update_appealed::case","restore_appealed::case","restore_any_appealed::case","replicate_appealed::case","reorder_appealed::case","delete_appealed::case","delete_any_appealed::case","force_delete_appealed::case","force_delete_any_appealed::case","import_appealed::case","export_appealed::case","view_case::timeliness::metric","view_any_case::timeliness::metric","create_case::timeliness::metric","update_case::timeliness::metric","restore_case::timeliness::metric","restore_any_case::timeliness::metric","replicate_case::timeliness::metric","reorder_case::timeliness::metric","delete_case::timeliness::metric","delete_any_case::timeliness::metric","force_delete_case::timeliness::metric","force_delete_any_case::timeliness::metric","import_case::timeliness::metric","export_case::timeliness::metric","view_indigent::litigant","view_any_indigent::litigant","create_indigent::litigant","update_indigent::litigant","restore_indigent::litigant","restore_any_indigent::litigant","replicate_indigent::litigant","reorder_indigent::litigant","delete_indigent::litigant","delete_any_indigent::litigant","force_delete_indigent::litigant","force_delete_any_indigent::litigant","import_indigent::litigant","export_indigent::litigant","view_monthly::case::workload","view_any_monthly::case::workload","create_monthly::case::workload","update_monthly::case::workload","restore_monthly::case::workload","restore_any_monthly::case::workload","replicate_monthly::case::workload","reorder_monthly::case::workload","delete_monthly::case::workload","delete_any_monthly::case::workload","force_delete_monthly::case::workload","force_delete_any_monthly::case::workload","import_monthly::case::workload","export_monthly::case::workload","view_prexc::indicator","view_any_prexc::indicator","create_prexc::indicator","update_prexc::indicator","restore_prexc::indicator","restore_any_prexc::indicator","replicate_prexc::indicator","reorder_prexc::indicator","delete_prexc::indicator","delete_any_prexc::indicator","force_delete_prexc::indicator","force_delete_any_prexc::indicator","import_prexc::indicator","export_prexc::indicator","view_rab::case","view_any_rab::case","create_rab::case","update_rab::case","restore_rab::case","restore_any_rab::case","replicate_rab::case","reorder_rab::case","delete_rab::case","delete_any_rab::case","force_delete_rab::case","force_delete_any_rab::case","import_rab::case","export_rab::case","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","import_user","export_user","page_Cases","page_Prexc","page_MyProfilePage","widget_RedirectToDashboard"]},{"name":"admin","guard_name":"web","permissions":["view_affirmance::rate","view_any_affirmance::rate","create_affirmance::rate","update_affirmance::rate","restore_affirmance::rate","restore_any_affirmance::rate","replicate_affirmance::rate","reorder_affirmance::rate","delete_affirmance::rate","delete_any_affirmance::rate","force_delete_affirmance::rate","force_delete_any_affirmance::rate","import_affirmance::rate","export_affirmance::rate","view_appealed::case","view_any_appealed::case","create_appealed::case","update_appealed::case","restore_appealed::case","restore_any_appealed::case","replicate_appealed::case","reorder_appealed::case","delete_appealed::case","delete_any_appealed::case","force_delete_appealed::case","force_delete_any_appealed::case","import_appealed::case","export_appealed::case","view_case::timeliness::metric","view_any_case::timeliness::metric","create_case::timeliness::metric","update_case::timeliness::metric","restore_case::timeliness::metric","restore_any_case::timeliness::metric","replicate_case::timeliness::metric","reorder_case::timeliness::metric","delete_case::timeliness::metric","delete_any_case::timeliness::metric","force_delete_case::timeliness::metric","force_delete_any_case::timeliness::metric","import_case::timeliness::metric","export_case::timeliness::metric","view_indigent::litigant","view_any_indigent::litigant","create_indigent::litigant","update_indigent::litigant","restore_indigent::litigant","restore_any_indigent::litigant","replicate_indigent::litigant","reorder_indigent::litigant","delete_indigent::litigant","delete_any_indigent::litigant","force_delete_indigent::litigant","force_delete_any_indigent::litigant","import_indigent::litigant","export_indigent::litigant","view_monthly::case::workload","view_any_monthly::case::workload","create_monthly::case::workload","update_monthly::case::workload","restore_monthly::case::workload","restore_any_monthly::case::workload","replicate_monthly::case::workload","reorder_monthly::case::workload","delete_monthly::case::workload","delete_any_monthly::case::workload","force_delete_monthly::case::workload","force_delete_any_monthly::case::workload","import_monthly::case::workload","export_monthly::case::workload","view_prexc::indicator","view_any_prexc::indicator","create_prexc::indicator","update_prexc::indicator","restore_prexc::indicator","restore_any_prexc::indicator","replicate_prexc::indicator","reorder_prexc::indicator","delete_prexc::indicator","delete_any_prexc::indicator","force_delete_prexc::indicator","force_delete_any_prexc::indicator","import_prexc::indicator","export_prexc::indicator","view_rab::case","view_any_rab::case","create_rab::case","update_rab::case","restore_rab::case","restore_any_rab::case","replicate_rab::case","reorder_rab::case","delete_rab::case","delete_any_rab::case","force_delete_rab::case","force_delete_any_rab::case","import_rab::case","export_rab::case","page_Cases","page_Prexc","page_MyProfilePage","widget_RedirectToDashboard"]},{"name":"commissioner","guard_name":"web","permissions":["view_affirmance::rate","view_any_affirmance::rate","view_appealed::case","view_any_appealed::case","view_case::timeliness::metric","view_any_case::timeliness::metric","view_indigent::litigant","view_any_indigent::litigant","view_monthly::case::workload","view_any_monthly::case::workload","view_prexc::indicator","view_any_prexc::indicator","view_rab::case","view_any_rab::case","page_Cases","page_Prexc","page_MyProfilePage","widget_RedirectToDashboard"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
