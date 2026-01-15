<div class="form-group">
    <label for="<?= $name ?>"><?= htmlspecialchars($label) ?></label>

    <textarea 
        name="<?= $name ?>" 
        id="<?= $name ?>"
        class="form-control <?= !empty($error) ? 'is-invalid' : '' ?>"
    ><?= $value ?? '' ?></textarea>

    <?php if (!empty($error)): ?>
        <div class="invalid-feedback">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
</div>