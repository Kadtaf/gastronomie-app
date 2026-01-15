<div class="form-group">
    <label for="<?= $name ?>"><?= htmlspecialchars($label) ?></label>

    <select 
        name="<?= $name ?>" 
        id="<?= $name ?>"
        class="form-control <?= !empty($error) ? 'is-invalid' : '' ?>"
    >
        <?php foreach ($options as $key => $text): ?>
            <option value="<?= htmlspecialchars($key) ?>"
                <?= ($selected == $key) ? 'selected' : '' ?>>
                <?= htmlspecialchars($text) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if (!empty($error)): ?>
        <div class="invalid-feedback">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
</div>