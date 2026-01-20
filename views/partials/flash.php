<?php
use App\Classes\Core\Flash;

$messages = Flash::getAll();

if (!empty($messages)):
?>
    <div class="flash-container">
        <?php foreach ($messages as $msg): ?>
            <div class="flash flash-<?= htmlspecialchars($msg['type']) ?>">
                <?= htmlspecialchars($msg['message']) ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>