<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title); ?> | ProjectPIPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
      <div class="container">
        <a class="navbar-brand" href="/">Warung Z&Z</a>
        
        <?php if(session()->get('isLoggedIn')): ?>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="/products">Produk</a></li>
            <li class="nav-item"><a class="nav-link" href="/pos">Kasir</a></li>
            <li class="nav-item"><a class="nav-link" href="/history">Riwayat Transaksi</a></li>
            
            <?php if(session()->get('role') == 'admin'): ?>
                <li class="nav-item"><a class="nav-link" href="/reports">Laporan</a></li>
            <?php endif; ?>
          </ul>
          
          <span class="navbar-text text-white me-3">
            Halo, <?= esc(session()->get('name')); ?> (<?= esc(ucfirst(session()->get('role'))); ?>)
          </span>
          <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
        <?php endif; ?>
        
      </div>
    </nav>

    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>