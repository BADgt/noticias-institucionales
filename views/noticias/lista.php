<h2>Lista de noticias</h2>

<?php while($row = mysqli_fetch_assoc($noticias)): ?>
    <div>
        <h3><?= htmlspecialchars($row['titulo']) ?></h3>
        <p><?= htmlspecialchars($row['contenido']) ?></p>
    </div>
<?php endwhile; ?>
