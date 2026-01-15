<?php if (!empty($messages)): ?>
    <div class="alerts">
        <?php foreach ($messages as $msg): ?>
            <div class="alert alert-<?= htmlspecialchars($msg['type']) ?>">
                <?= htmlspecialchars($msg['message']) ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>