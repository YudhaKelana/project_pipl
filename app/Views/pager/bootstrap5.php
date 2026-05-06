<?php

/**
 * Custom Pagination Template - Bootstrap 5
 * Digunakan oleh halaman Produk dan halaman lain yang membutuhkan pagination.
 *
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>

<nav aria-label="Navigasi Halaman">
    <ul class="pagination pagination-sm mb-0">
        
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getFirst() ?>" class="page-link" aria-label="First" title="Halaman Pertama">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getPrevious() ?>" class="page-link" aria-label="Previous" title="Sebelumnya">
                    <span aria-hidden="true">&lsaquo;</span>
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getNext() ?>" class="page-link" aria-label="Next" title="Selanjutnya">
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getLast() ?>" class="page-link" aria-label="Last" title="Halaman Terakhir">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</nav>
