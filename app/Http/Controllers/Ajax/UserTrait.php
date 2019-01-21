<?php

namespace App\Http\Controllers\Ajax;

use App\Content;
use App\Facades\System;
use App\Helpers\Formatting;
use App\Role;
use App\RolePermission;
use App\Upload;
use App\User;
use Illuminate\Support\Facades\Validator;

trait UserTrait
{
    protected function userIndex()
    {
        switch ($this->request->get('job')) {
            case 'createUser':
                return $this->createUser();
                break;

            case 'getUser':
                return $this->getUser();
                break;

            case 'getUsers':
                return $this->getUsers();
                break;

            case 'getRoles':
                return $this->getRoles();
                break;

            case 'createRole':
                return $this->createRole();
                break;

            case 'getRolePerms':
                return $this->getRolePerms();
                break;

            case 'setRolePerm':
                return $this->setRolePerm();
                break;
        }

        return false;
    }

    protected function createUser()
    {
        $data = $this->request->input('data');
        $validator = Validator::make($data, [
            'id' => 'integer|min:0',
            'username' => 'string|required',
            'email' => 'required|email|unique:users,email' . (isset($data['id']) && $data['id'] > 0 ? ',' . $data['id'] : ''),
            'role_id' => 'integer|required',
            'password' => 'required|confirmed|min:6',
            'status' => 'integer'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 0,
                'message' => $validator->messages()->first()
            ];
        }

        if ($this->request->file('data.avatar')) {
            $upload = Upload::newFile($this->request->file('data.avatar'), 'user/avatar');
            if ($upload)
                $data['avatar_id'] = $upload->id;
        }

        $data['password'] = bcrypt($data['password']);
        if ($data['id'] > 0) { // Edit
            $user = User::find($data['id']);

            if (!$user) {
                return [
                    'status' => 0,
                    'message' => 'Düzenlenmek istenen kullanıcı bulunamadı'
                ];
            }

            $user->update($data);
        } else { // Create
            $user = User::create($data);
        }

        if (!$user) {
            return [
                'status' => 0,
                'message' => 'Kullanıcı kaydedilirken bir hata oluştu'
            ];
        }

        return [
            'status' => 1,
            'message' => 'Kullanıcı başarıyla kaydedildi'
        ];
    }

    protected function getUser()
    {
        $data = $this->request->get('data');
        $user = User::where('id', $data['id'])
            ->first();

        if (!$user) {
            return [
                'status' => 0,
                'message' => 'Kullanıcı bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                    'avatar' => $user->avatar,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'status' => $user->status
                ]
            ]
        ];
    }

    protected function getUsers()
    {
        $_users = User::paginate(30);

        $pageLinks = System::pageLinks([
            'total' => $_users->total(),
            'per_page' => $_users->perPage(),
            'current_page' => $_users->currentPage(),
            'last_page' => $_users->lastPage()
        ]);

        $users = [];
        foreach ($_users as $user) {
            $users[] = [
                'id' => $user->id,
                'username' => $user->username,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'avatar' => $user->avatar,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'status' => $user->status
            ];
        }

        if (empty($users)) {
            return [
                'status' => 0,
                'message' => 'Kullanıcı bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'users' => $users
            ],
            'pageLinks' => $pageLinks
        ];
    }

    protected function getRoles()
    {
        $_roles = Role::whereRaw('1 = 1');
        $sorting = $this->request->input('sorting');
        if ($sorting && is_array($sorting)) {
            foreach ($sorting as $key => $value) {
                $_roles->orderBy($key, $value);
            }
        }
        $_roles = $_roles->paginate(30);

        $pageLinks = System::pageLinks([
            'total' => $_roles->total(),
            'per_page' => $_roles->perPage(),
            'current_page' => $_roles->currentPage(),
            'last_page' => $_roles->lastPage()
        ]);

        $roles = [];
        foreach ($_roles as $role) {
            $roles[] = [
                'id' => $role->id,
                'slug' => $role->slug,
                'name' => $role->name,
                'created_at' => $role->created_at->format('Y-m-d H:i:s'),
                'status' => $role->status
            ];
        }

        if (empty($roles)) {
            return [
                'status' => 0,
                'message' => 'Kullanıcı bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'roles' => $roles
            ],
            'pageLinks' => $pageLinks
        ];
    }

    protected function createRole()
    {
        $data = $this->request->input('data');
        $validator = Validator::make($data, [
            'id' => 'integer|min:0',
            'slug' => 'string|required',
            'name' => 'string|required',
            'status' => 'integer'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 0,
                'message' => $validator->messages()->first()
            ];
        }

        if ($data['id'] > 0) { // Edit
            $role = Role::find($data['id']);

            if (!$role) {
                return [
                    'status' => 0,
                    'message' => 'Düzenlenmek istenen rol bulunamadı'
                ];
            }

            $role->update($data);
        } else { // Create
            $role = Role::create($data);
        }

        if (!$role) {
            return [
                'status' => 0,
                'message' => 'Rol kaydedilirken bir hata oluştu'
            ];
        }

        return [
            'status' => 1,
            'message' => 'Rol başarıyla kaydedildi'
        ];
    }

    protected function getRolePerms()
    {
        $data = $this->request->input('data');
        $roles = Role::whereIn('id', $data['roles'])
            ->orderBy('name')
            ->pluck('id')
            ->toArray();

        $_rolePerms = RolePermission::whereIn('role_id', $roles)
            ->get();
        $rolePerms = [];
        foreach ($_rolePerms as $rolePerm) {
            $rolePerms[$rolePerm->name][$rolePerm->role_id] = $rolePerm->can_do;
        }

        $perms = __('permission');
        asort($perms);

        $hasPerms = [];
        foreach ($perms as $perm => $name) {
            foreach ($roles as $role_id) {
                if (!isset($rolePerms[$perm][$role_id]))
                    $rolePerms[$perm][$role_id] = 0;
            }

            $hasPerms[] = [
                'perm' => $perm,
                'name' => $name,
                'roles' => $rolePerms[$perm]
            ];
        }


        return [
            'status' => 1,
            'data' => [
                'has_perms' => $hasPerms
            ]
        ];
    }

    protected function setRolePerm()
    {
        $rolePerm = RolePermission::where('role_id', $this->request->input('data.role_id'))
            ->where('name', $this->request->input('data.name'))
            ->first();

        if (!$rolePerm) {
            $rolePerm = RolePermission::create([
                'role_id' => $this->request->input('data.role_id'),
                'name' => $this->request->input('data.name'),
                'can_do' => $this->request->input('data.can_do') ?? 0
            ]);

            if ($rolePerm) {
                return [
                    'status' => 1,
                    'message' => 'Rol için izin başarıyla oluşturuldu.'
                ];
            }
        } elseif ($rolePerm->update([
                'can_do' => $this->request->input('data.can_do') ?? 0
            ])) {
            return [
                'status' => 1,
                'message' => 'Rol için izin başarıyla güncellendi.'
            ];
        }

        return [
            'status' => 0,
            'message' => 'İzin rol için kaydedilirken bir hata oluştu'
        ];
    }
}
