<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
</head>
<body class="user-admin-body">

    <div class="user-admin-container">
        <h2 class="user-admin-title">Edit User</h2>

        <form action="<?= base_url('admin/users/update/'.$user['id_user']); ?>" method="post" class="user-admin-form">
            <input type="text" name="username" value="<?= $user['username']; ?>" required>
            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
            <input type="text" name="nama_pengguna" value="<?= $user['nama_pengguna']; ?>" required>
            <select name="role" required>
                <option value="admin" <?= $user['role']=='admin'?'selected':''; ?>>Admin</option>
                <option value="user" <?= $user['role']=='user'?'selected':''; ?>>User</option>
            </select>
            <button type="submit" class="user-admin-btn">Update</button>
        </form>
    </div>

</body>
</html>
