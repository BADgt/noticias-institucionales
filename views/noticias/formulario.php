<h2>Crear Nueva Noticia</h2>

<?php if (!empty($errores)): ?>
    <div style="background: #ffdbdb; color: #a90000; border: 1px solid; padding: 10px; margin-bottom: 20px;">
        <strong>Corregir los siguientes errores:</strong>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="?page=guardar-noticia">
    <div style="margin-bottom: 10px;">
        <label>Título (10-100 caracteres):</label><br>
        <input type="text" name="titulo" style="width: 100%;" required value="<?= e($_POST['titulo'] ?? '') ?>">
    </div>

    <div style="margin-bottom: 10px;">
        <label>Descripción (Mínimo 50 caracteres):</label><br>
        <textarea name="contenido" rows="5" style="width: 100%;" required><?= e($_POST['contenido'] ?? '') ?></textarea>
    </div>

    <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer;">
        Guardar Noticia
    </button>
</form>