<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    public function updateProfile()
    {
        $userId = session()->get('user_id');

        $file = $this->request->getFile('profile_image');
        $model = new UserModel();

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Nama acak
            $newName = $file->getRandomName();
            $file->move('uploads/profile', $newName);

            // Update database
            $model->update($userId, [
                'foto' => $newName
            ]);

            // Update session juga!
            session()->set('foto', $newName);
        }

        return redirect()->to('/user/profile')->with('success', 'Foto profil berhasil diperbarui!');
    }
}
