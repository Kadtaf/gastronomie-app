<div class="form-group">
    <label for="<?= $name ?>"><?= htmlspecialchars($label) ?></label>

    <input 
        type="<?= $type ?? 'text' ?>" 
        name="<?= $name ?>" 
        id="<?= $name ?>"
        value="<?= $value ?? '' ?>"
        class="form-control <?= !empty($error) ? 'is-invalid' : '' ?>"
    >

    <?php if (!empty($error)): ?>
        <div class="invalid-feedback">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
</div>