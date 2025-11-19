<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Admin Warung Z&Z</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-4">Login Admin</h3>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('auth/process') ?>" method="post">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Masuk</button>
                <a href="<?= base_url('pos') ?>" class="btn btn-outline-secondary">Kembali ke Kasir</a>
            </div>
        </form>
    </div>

</body>
</html>