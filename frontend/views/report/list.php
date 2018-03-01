<?php foreach($data as $plan => $profiles) : ?>
	<h2><?= $plan ?></h2>
		<?php foreach($profiles as $profile => $types) : ?>
			<h3><?= $profile ?></h3>
			<?php foreach($types as $type => $programs) : ?>
				<h4><?= $type ?></h4>
				<?php foreach($programs as $program) : ?>
					<?= $program['title'] ?></br>
				<?php endforeach; ?>
			<?php endforeach; ?>
		<?php endforeach; ?>
<?php endforeach; ?>

