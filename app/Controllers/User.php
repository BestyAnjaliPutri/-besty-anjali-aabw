<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $builder = $this->db->table('users');
        $builder->select('users.id as userid, users.username, users.email, users.active, users.created_at, auth_groups.id as group_id, auth_groups.name as group_name');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
        $builder->where('users.deleted_at', null);
        $builder->orderBy('users.id', 'ASC');
        $data['users'] = $builder->get()->getResult();

        // Ambil semua daftar group/role
        $data['groups'] = $this->db->table('auth_groups')->get()->getResult();

        return view('user/index', $data);
    }

    public function changeRole($id = null)
    {
        $groupId = $this->request->getPost('group_id');
        if ($id && $groupId) {
            $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
            $this->db->table('auth_groups_users')->insert([
                'user_id' => $id,
                'group_id' => $groupId,
            ]);
            return redirect()->to(site_url('user'))->with('success', 'Role pengguna berhasil diperbarui.');
        }
        return redirect()->to(site_url('user'))->with('error', 'Gagal memperbarui role pengguna.');
    }

    public function toggleStatus($id = null)
    {
        if ($id) {
            $user = $this->db->table('users')->where('id', $id)->get()->getRow();
            if ($user) {
                $newStatus = ($user->active == 1) ? 0 : 1;
                $this->db->table('users')->where('id', $id)->update(['active' => $newStatus]);
                $msg = ($newStatus == 1) ? 'Pengguna berhasil diaktifkan.' : 'Pengguna berhasil dinonaktifkan.';
                return redirect()->to(site_url('user'))->with('success', $msg);
            }
        }
        return redirect()->to(site_url('user'))->with('error', 'Pengguna tidak ditemukan.');
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
            $this->db->table('users')->where('id', $id)->delete();
            return redirect()->to(site_url('user'))->with('success', 'Pengguna berhasil dihapus.');
        }
        return redirect()->to(site_url('user'))->with('error', 'Pengguna tidak ditemukan.');
    }
}
