<div id="navigationwrap" class="row">
				<div id="navigation">
					EXAMINATION INVIGILATION DUTY ROSTER<br />
					<span class="sessionyear"><?= $name['session']; ?></span> Session (<?= $semester['current_semester'] ?>)
				</div>

				<?php // date here ?>
				<div id="thedate">
					<div id="aligndate"><?php $today = date(" l jS F, Y ") ;  echo $today; ?></div>
				</div>
</div>