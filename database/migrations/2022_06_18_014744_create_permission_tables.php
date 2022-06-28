<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('name_cn');
            $table->bigInteger('parent_id')->default(1);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id');
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('name_cn');
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([PermissionRegistrar::$pivotPermission, PermissionRegistrar::$pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
        // 创建默认角色
        $administrator=Role::create(['name'=>'administrator','name_cn'=>'超级管理员']);
        $manager=Role::create(['name'=>'manager','name_cn'=>'管理员']);
        $subscriber=Role::create(['name'=>'subscriber','name_cn'=>'订阅者']);
        $author=Role::create(['name'=>'author','name_cn'=>'作者']);
        $contributor=Role::create(['name'=>'contributor','name_cn'=>'贡献者']);
        $editor=Role::create(['name'=>'editor','name_cn'=>'编辑']);

        // 创建默认权限
        $manage_everything=Permission::create(['name'=>'manage','name_cn'=>'所有权限','parent_id'=>0]); 
        $manage_setting=Permission::create(['name'=>'manage','name_cn'=>'通用配置','parent_id'=>$manage_everything->id]); 
        $add_setting=Permission::create(['name'=>'add','name_cn'=>'通用配置-添加','parent_id'=>$manage_setting->id]); 
        $edit_setting=Permission::create(['name'=>'edit','name_cn'=>'通用配置-修改','parent_id'=>$manage_setting->id]); 
        $delete_setting=Permission::create(['name'=>'delete','name_cn'=>'通用配置-删除','parent_id'=>$manage_setting->id]); 
        $view_setting=Permission::create(['name'=>'view','name_cn'=>'通用配置-查看','parent_id'=>$manage_setting->id]); 
        $manage_permission=Permission::create(['name'=>'manage','name_cn'=>'权限管理','parent_id'=>$manage_everything->id]); 
        $add_permission=Permission::create(['name'=>'add','name_cn'=>'权限管理-添加','parent_id'=>$manage_permission->id]); 
        $edit_permission=Permission::create(['name'=>'edit','name_cn'=>'权限管理-修改','parent_id'=>$manage_permission->id]); 
        $delete_permission=Permission::create(['name'=>'delete','name_cn'=>'权限管理-删除','parent_id'=>$manage_permission->id]); 
        $view_permission=Permission::create(['name'=>'view','name_cn'=>'权限管理-查看','parent_id'=>$manage_permission->id]); 
        $manage_role=Permission::create(['name'=>'manage','name_cn'=>'角色管理','parent_id'=>$manage_everything->id]); 
        $add_role=Permission::create(['name'=>'add','name_cn'=>'角色管理-添加','parent_id'=>$manage_role->id]); 
        $edit_role=Permission::create(['name'=>'edit','name_cn'=>'角色管理-编辑','parent_id'=>$manage_role->id]); 
        $delete_role=Permission::create(['name'=>'delete','name_cn'=>'角色管理-删除','parent_id'=>$manage_role->id]); 
        $view_role=Permission::create(['name'=>'view','name_cn'=>'角色管理-查看','parent_id'=>$manage_role->id]); 
        $manage_user=Permission::create(['name'=>'manage','name_cn'=>'用户管理','parent_id'=>$manage_everything->id]); 
        $add_user=Permission::create(['name'=>'add','name_cn'=>'用户管理-添加','parent_id'=>$manage_user->id]); 
        $edit_user=Permission::create(['name'=>'edit','name_cn'=>'用户管理-编辑','parent_id'=>$manage_user->id]); 
        $delete_user=Permission::create(['name'=>'delete','name_cn'=>'用户管理-删除','parent_id'=>$manage_user->id]); 
        $view_user=Permission::create(['name'=>'view','name_cn'=>'用户管理-查看','parent_id'=>$manage_user->id]); 
        $manage_post=Permission::create(['name'=>'manage','name_cn'=>'文章管理','parent_id'=>$manage_everything->id]); 
        $add_post=Permission::create(['name'=>'add','name_cn'=>'文章管理-添加','parent_id'=>$manage_post->id]); 
        $edit_post=Permission::create(['name'=>'edit','name_cn'=>'文章管理-编辑','parent_id'=>$manage_post->id]); 
        $delete_post=Permission::create(['name'=>'delete','name_cn'=>'文章管理-删除','parent_id'=>$manage_post->id]); 
        $view_post=Permission::create(['name'=>'view','name_cn'=>'文章管理-查看','parent_id'=>$manage_post->id]); 
        $manage_page=Permission::create(['name'=>'manage','name_cn'=>'页面管理','parent_id'=>$manage_everything->id]); 
        $add_page=Permission::create(['name'=>'add','name_cn'=>'页面管理-添加','parent_id'=>$manage_page->id]); 
        $edit_page=Permission::create(['name'=>'edit','name_cn'=>'页面管理-编辑','parent_id'=>$manage_page->id]); 
        $delete_page=Permission::create(['name'=>'delete','name_cn'=>'页面管理-删除','parent_id'=>$manage_page->id]); 
        $view_page=Permission::create(['name'=>'view','name_cn'=>'页面管理-查看','parent_id'=>$manage_page->id]); 
        $manage_tag=Permission::create(['name'=>'manage','name_cn'=>'标签管理','parent_id'=>$manage_everything->id]); 
        $add_tag=Permission::create(['name'=>'add','name_cn'=>'标签管理-添加','parent_id'=>$manage_tag->id]); 
        $edit_tag=Permission::create(['name'=>'edit','name_cn'=>'标签管理-编辑','parent_id'=>$manage_tag->id]); 
        $delete_tag=Permission::create(['name'=>'delete','name_cn'=>'标签管理-删除','parent_id'=>$manage_tag->id]); 
        $view_tag=Permission::create(['name'=>'view','name_cn'=>'标签管理-查看','parent_id'=>$manage_tag->id]);
        $manage_menu=Permission::create(['name'=>'manage','name_cn'=>'菜单管理','parent_id'=>$manage_everything->id]); 
        $add_menu=Permission::create(['name'=>'add','name_cn'=>'菜单管理-添加','parent_id'=>$manage_menu->id]); 
        $edit_menu=Permission::create(['name'=>'edit','name_cn'=>'菜单管理-编辑','parent_id'=>$manage_menu->id]); 
        $delete_menu=Permission::create(['name'=>'delete','name_cn'=>'菜单管理-删除','parent_id'=>$manage_menu->id]); 
        $view_menu=Permission::create(['name'=>'view','name_cn'=>'菜单管理-查看','parent_id'=>$manage_menu->id]); 

        //角色授权
        $permissions=Permission::all();
        $administrator->syncPermissions($permissions);
        $user=User::first();
        // 给超级管理员授权
        $user->assignRole('administrator');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
