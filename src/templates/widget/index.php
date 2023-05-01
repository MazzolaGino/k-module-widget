<h1>Mvc Sharing Options</h1>

<form method="post" action="<?= $referer ?>">

	<input type="hidden" name="option_page" value="configuration_group"> <input
		type="hidden" name="action" value="update"> <input type="hidden"
		id="_wpnonce" name="_wpnonce" value="1d36b93252">

	<h2>Twitter Settings</h2>
	<table class="form-table" role="presentation">
		<tbody>
            <?php foreach ($values as $key => $value): ?>
                <tr>
				<th scope="row">
                        <?= str_replace('_', ' ', $key) ?>
                    </th>
				<td><input type="text" name="<?= $key ?>" style="width: 100%"
					value="<?= !empty($value) ? $value : '' ?>"></td>
			</tr>
            <?php endforeach; ?>
        </tbody>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit"
			class="button button-primary" value="Enregistrer les modifications">
	</p>
</form>