
<?php if (isset($project)): ?>
<form class="project-form">
	<input type="hidden" name="id" value="<?=$project -> id?>">
	<div class="form-group">
		<input type="text" class="form-control" data-id="<?=$project -> id?>" name="project_name" value="<?=$project -> project_name?>" placeholder="Название рекламной акции" />
	</div>
	<div class="form-group">
		<select class="form-control" name="project_type">
			<option value="0">Выберите тип проекта</option>
			<option value="1" <?php if ($project -> type == 1) {echo 'selected';} ?>>Лотерея (один код, выйгрывает один человек)</option>
			<option value="2" <?php if ($project -> type == 2) {echo 'selected';} ?>>Выигрывают все (много кодов, каждый выйгрышный)</option>
		</select>
	</div>
	<div class="form-group">
		<input type="text" class="form-control" name="project_qr_count" value="<?=$project -> qr_count?>" placeholder='Количество кодов (используется при типе "Выигрывают все")' />
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary btn-block generate">Сгенерировать</button>
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary btn-block generate-winner">Выбрать победителя (только для лотереи)</button>
	</div>
	
	
	<div class="qr-container row">
<?php
	$res = $db -> query("SELECT * FROM codes WHERE project_id='{$project -> id}'");
	
	while ($code = $res -> fetch_object()):
?>
		<div class="col-sm-4">
			<img style="width: 100%" src="<?=$code -> image?>" />
			<div class="mb-3">
				<a target="_blank" download href="<?=$code -> image?>">Скачать</a>
			</div>
<?php 
if ($project -> type == 2): 
	$res2 = $db -> query("SELECT * FROM codes_data WHERE codes_id = '{$code -> code}'");
	if ($res2 -> num_rows > 0):
		$scanned = $res2 -> fetch_object();
?>
			<div>
				Выйгравший номер: <?=$scanned -> phone?><br>
				<a target="_blank" href="https://www.raiffeisen.ru/retail/remote_service/card2card/">перейти для оплаты</a>
<?php if ($scanned -> state == 1): ?>
				<div class="text-success">ОПЛАЧЕННО</div>
<?php else: ?>
				<a href="#" data-id="<?=$scanned -> id?>" class="mark-as-payed text-success">ПОМЕТИТЬ КАК ОПЛАЧЕННОЕ</a>
<?php endif; ?>
			</div>
				
<?php 
		endif;	
	else:

	$res2 = $db -> query("SELECT * FROM codes_data WHERE codes_id = '{$code -> code}' AND state=2");
	if ($res2 -> num_rows > 0):
		$scanned = $res2 -> fetch_object();
?>
			<div>
				Выйгравший номер: <?=$scanned -> phone?><br>
				<a target="_blank" href="https://www.raiffeisen.ru/retail/remote_service/card2card/">перейти для оплаты</a>
<?php if ($scanned -> state == 1): ?>
				<div class="text-success">ОПЛАЧЕННО</div>
<?php else: ?>
				<a href="#" data-id="<?=$scanned -> id?>" class="mark-as-payed text-success">ПОМЕТИТЬ КАК ОПЛАЧЕННОЕ</a>
<?php endif; ?>
			</div>
				
<?php 
		endif;

 endif; ?>
		</div>
<?php endwhile; ?>
	</div>
</form>


<?php else: ?>

<h1>Добавьте рекламную акцию</h1>

<?php endif; ?>

<?php /*
	<div class="card-region-wrapper new-card">
		<div class="card-region-titled">
			<img class="card-logo" src="inc/images/MASTERCRD.png" />
		</div>
		<div class="card-region-row">
			<div class="card-element-wrapper">
				<input data-inputmask="'mask' : '9999 9999 9999 9999'" autocomplete="off" type="phone" class="nice-input-text" data-placeholder="Номер карты" />
			</div> 
		</div>
		<div class="card-region-row">
			<div class="row no-gutters justify-content-between align-items-center">
				<div class="col-auto">
					<div class="card-element-wrapper date-cew">
						<input data-inputmask="'mask' : '99/99'" autocomplete="off" type="phone" class="nice-input-text" data-placeholder="Месяц/год" />
					</div>
				</div>
				<div class="col-auto">
					<div class="card-element-wrapper cvv-cew">
						<input data-inputmask="'mask' : '999'" value="" maxlength="3" autocomplete="off" type="text" class="nice-input-text" data-placeholder="CVC2/CVV2" />
					</div>
				</div>
				<div class="col-auto">
					<div class="element-hover-desc" data-hover-description="3 цифры с обратной стороны карты">
						<img class="helper-image" src="inc/images/svg-sprite.svg?1.181.4#question" />
					</div>
				</div>
			</div>
		</div>
	</div>
	
*/ ?>