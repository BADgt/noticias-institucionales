<?php if (!empty($errores)): ?>
    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
        <ul class="mb-0">
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>