<table class="table">
    <thead>
        <tr>
            <?php foreach ($columns as $col): ?>
                <th><?= htmlspecialchars($col) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <?php foreach ($fields as $field): ?>

                    <?php
                    // Si $row est un objet → on cherche un getter
                    if (is_object($row)) {
                        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));

                        $value = method_exists($row, $method)
                            ? $row->$method()
                            : null;
                    }
                    // Si $row est un tableau associatif
                    else {
                        $value = $row[$field] ?? null;
                    }
                    ?>

                    <td><?= htmlspecialchars((string) $value) ?></td>

                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>