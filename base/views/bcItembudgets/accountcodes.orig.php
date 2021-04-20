<style>
	.container {
		display: table;
		text-size: 12px;
	}

	.row {
		display: table-row;
	}

	.left,
	.right,
	.middle {
		display: table-cell;
	}
</style>
<?php
if ($_REQUEST['print'] == 1) {
?>
	<link rel="stylesheet" type="text/css" href="css/gridview/styles.css">
	<link rel="stylesheet" href="css/styles.css" type="text/css">
	<center>
		<h1><img src='images/uetcl_logo.png' width=200 /><br />Uganda Electricity Transmission Company Limited</h1>
		<h2>Budget Check Report - Financial Year <?= budget('name') ?></h2>
	</center>
	<hr>
<?php
} else { ?>

	<form method='get'>
		<input type='hidden' name='r' value='bcItembudgets/accountcodes'>
		<div class="search-form" style="display:block">
			<div class='container'>
				<?php if (is_proc_officer() or is_manager_finance() or is_sys_admin() or is_sat() or is_pbfo()) { ?>
					<div class='row'>
						<div class='left'><?= CHtml::label('Section: ', false) ?> <small><em> (Leave blank to get all sections)</em></small></div>
						<div class='middle'> <?php
												$rl = app()->db->CreateCommand("select * from v_sections order by dshortname,sshortname")->queryAll();
												$role_list = array();
												foreach ($rl as $r) $role_list[$r['sectionid']] = $r['dshortname'] . " - " . $r['sshortname'];
												echo CHtml::dropDownList('section', array($_REQUEST['section']), $role_list, array('onChange' => "document.getElementById('ProcurementSpending_items').innerHTML='';document.getElementById('accountcode').value=''", 'style' => 'width:270px', 'empty' => ' - Select a Section- ')); ?>
						</div>
					</div>
				<?php } ?>

				<div class="row">
					<div class='left'><?= CHtml::label('Cost Center: ', false) ?><small><em> (Leave blank for entire budget)</em></small></div>
					<div class='middle'>
						<?php
						$rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
						$role_list = array();
						foreach ($rl as $r) $role_list[$r[accountcode]] = $r[accountcode] . " - " . $r[item];
						echo Chtml::dropDownList(
							'costcentre',
							$_REQUEST['costcentre'],
							$role_list,
							array(
								'style' => 'width:270px',
								'empty' => ' - Select a Cost Centre - ',
								'ajax' => array(
									'type' => 'POST',
									'url' => CController::createUrl('Items/item'),
									'update' => '#Items_accountcode',
								),
							)
						);
						?>
					</div>
				</div>
				<div class="row">
					<div class='left'><?= CHtml::label('Account Code: ', false) ?><small><em> (Leave blank to stop at cost centre level)</em></small></div>
					<div class='middle'>
						<?php
						echo Chtml::dropDownList('accountcode', $_REQUEST['accountcode'], array(), array(
							'style' => 'width:270px',
							'prompt' => '- select -',
							'id' => 'Items_accountcode',
							'ajax' => array(
								'type' => 'POST',
								'url' => CController::createUrl('items/accountcode'),
								'update' => '#Items_item',
							),

						));
						?>
					</div>
				</div>
				<div class="row">
					<div class='left'><?= CHtml::label('Item: ', false) ?> <small><em> (Leave blank to stop at account code level)</em></small></div>
					<div class='middle'>
						<?php
						echo Chtml::dropDownList('item', array(), array(), array(
							'style' => 'width:270px',
							'prompt' => '- select -',
							'id' => 'Items_item',
						));
						?>
					</div>
				</div>




				<div class='row'>
					<div class='left'></div>
					<div class='middle'><input type='submit' value='Search' /></div>
				</div>
			</div><!-- search-form -->
	</form>
<?php } ?>
<center>
	<div id="bc-itembudgets-grid" class="grid-view">

		<?php
		if ($_REQUEST['item'] && !$model) echo "<strong style='color:red'>No Results for the section and account item selected</strong>";
		if ($model && $_REQUEST['item'] && $_REQUEST['section']) { ?>

			<h3>Budget Check Results</h3>
			<table style='width:70%'>
				<tr>
					<td>
						<h4>Section:</h4>
					</td>
					<td>
						<h3><b><?= $model[0]['dept'] ?> - <?= $model[0]['sectionname'] ?></b></h3>
					</td>
				</tr>
				<tr>
					<td>
						<h4>Account Code:</h4>
	</div>
	<td>
		<h3><?= $model[0]['accountcode'] ?> - <?= $model[0]['accountitem'] ?></h3>
	</td>
	</tr>
	<tr>
		<td>
			<h4>Item:</h4>
		</td>
		<td>
			<h3><?= $model[0]['itemname'] ?></h3>
		</td>
	</tr>
	</table>


	<table class="items">
		<thead>
			<tr>
				<th id="bc-itembudgets-grid_c0">Reason</th>
				<th id="bc-itembudgets-grid_c1">Status</th>
				<th id="bc-itembudgets-grid_c2">Amount</th>
				<th id="bc-itembudgets-grid_c3">Balance</th>
		</thead>
		<tbody>
			<?php
			foreach ($model as $r) {
				//print_r($r);echo "<br>";
				$c = ++$i % 2 == 0 ? "even" : "odd";
				$bal += $r['amount'];
				$rs = $r['reason'] == 3 || $r['reason'] == 6 ? CHtml::link($r['reasonname'], array('bcBudgetrequests/view', 'id' => $r['reasonid'])) : $r['reasonname'];
			?>
				<tr class=<?= $c ?>>
					<td><?= $rs ?></td>
					<td><?= $r['status'] ?></td>
					<td style='text-align:right'><?= Yii::app()->numberFormatter->formatCurrency($r['amount'], '') ?></td>
					<td style='text-align:right'><?= Yii::app()->numberFormatter->formatCurrency($bal, '') ?></td>
				</tr>
			<?php }
			$c = ++$i % 2 == 0 ? "even" : "odd";
			?>
			<tr class=<?= $c ?>>
				<td colspan=3>Balance on this Item (Including Pending Items)<em style='vertical-align: supper;
    font-size: smaller;'>This is the balance that will be seen during budget check</em></td>
				<td style='text-align:right'><strong><?= Yii::app()->numberFormatter->formatCurrency($bal, '') ?></strong></td>
			</tr>

		</tbody>
	</table>
	</div>
<?php } //ifmodel and section and item 
?>

<?php
if ($model && $_REQUEST['item']) {
	$sql = "select distinct section,sectionname,dept,accountitem,itemname from v_bc_itembudgets where budget='" . budget() . "'  and item=" . $_REQUEST['item'] . ' order by dept,sectionname';
	//echo $sql;
	$rawData = Yii::app()->db->createCommand($sql)->queryAll();
?>

	<h3>Budget History for Item: <?= $rawData[0]['accountitem'] ?> - <?= $rawData[0]['itemname'] ?>
		<table class="items">
			<thead>
				<tr>
					<th id="bc-itembudgets-grid_c0">Section</th>
					<th id="bc-itembudgets-grid_c1">Budget</th>
					<th id="bc-itembudgets-grid_c2">Reallocations</th>
					<th id="bc-itembudgets-grid_c3">Committed</th>
					<th id="bc-itembudgets-grid_c4">Pending</th>
					<th id="bc-itembudgets-grid_c5">Balance</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($rawData as $r) {
				?>
					<tr>
						<td><?= $r['dept'] ?> - <?= $r['sectionname'] ?></td>
						<td><?=
							Yii::app()->numberFormatter->formatCurrency(Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where section='" . $r['section'] . "' and item='" . $_REQUEST['item'] . "' and budget=" . budget() . " and reason in (1)")->queryScalar(), '');
							//echo "Select sum(amount) from v_bc_itembudgets where section='".$r['section']."' and item='".$_REQUEST['item']."' and reason in (1)";
							?></td>
						<td><?=
							number_format(Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where section='" . $r['section'] . "' and item='" . $_REQUEST['item'] . "' and  budget=" . budget() . " and reason in (2,5,4)")->queryScalar());
							?></td>
						<td><?=
							Yii::app()->numberFormatter->formatCurrency(Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where section='" . $r['section'] . "' and item='" . $_REQUEST['item'] . "' and `status`='COMMITED' and  budget=" . budget() . " and reason in (3,6)")->queryScalar(), '');
							?></td>
						<td><?=
							number_format(Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where section='" . $r['section'] . "' and item='" . $_REQUEST['item'] . "' and `status`='PENDING' and   budget=" . budget() . " and reason in (3,6)")->queryScalar());
							?></td>
						<td><?=
							number_format(Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where section='" . $r['section'] . "' and  budget=" . budget() . " and item='" . $_REQUEST['item'] . "' ")->queryScalar());
							?></td>
					</tr>
				<?php		}
				?>

			</tbody>
		</table>

	<?php } ?>

	<?php
	if ($model && $_REQUEST['accountcode'] && !$_REQUEST['item']) {
		$sql = "select distinct section,sectionname,dept,accountitem from v_bc_itembudgets where budget='" . budget() . "'  and accountid ='" . $_REQUEST['accountcode'] . "' order by dept,sectionname";
		$rawData = Yii::app()->db->createCommand($sql)->queryAll();
	?>

		<h3>Budget History for Account Code: <?= $rawData[0]['accountitem'] ?>

			<div id='foo' class='grid-view'>
				<table class="items">
					<thead>
						<tr>
							<th id="bc-itembudgets-grid_c0">Section</th>
							<th id="bc-itembudgets-grid_c1">Budget</th>
							<th id="bc-itembudgets-grid_c2">Re-Allocations</th>
							<th id="bc-itembudgets-grid_c3">Committed</th>
							<th id="bc-itembudgets-grid_c4">Pending</th>
							<th id="bc-itembudgets-grid_c5">Balance</th>
						</tr>
					</thead>
					<tbody>
						<?php
						function escape($str)
						{
							return preg_replace("/\'/", "\\\'", $str);
						}
						//die(escape("wilson's"));
						foreach ($rawData as $r) {
							$sql2 = "select distinct itemname,item from v_bc_itembudgets where section='" . $r['section'] . "' and budget='" . budget() . "'  and accountid ='" . $_REQUEST['accountcode'] . "' order by itemname";
							//echo $sql2;
							$rawData2 = Yii::app()->db->createCommand($sql2)->queryAll();
							$ctr = $commits = $reallocs = $budgets = $pendings = $balances = 0;
							foreach ($rawData2 as $r2) {
								$ctr++;
								$budget = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and itemname='" . escape($r2[itemname]) . "' and section='" . $r['section'] . "' and accountid='" . $_REQUEST['accountcode'] . "' and reason in (1)")->queryScalar();
								$realloc = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and itemname='" . escape($r2[itemname]) . "' and section='" . $r['section'] . "' and accountid='" . $_REQUEST['accountcode'] . "' and reason in (2,5,4)")->queryScalar();
								$commit = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and itemname='" . escape($r2[itemname]) . "' and section='" . $r['section'] . "' and accountid='" . $_REQUEST['accountcode'] . "' and `status`='COMMITED' and reason in (3,6)")->queryScalar();
								$pending = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and itemname='" . escape($r2[itemname]) . "' and section='" . $r['section'] . "' and accountid='" . $_REQUEST['accountcode'] . "' and `status`='PENDING' and  reason in (3,6)")->queryScalar();
								$balance = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and  itemname='" . escape($r2[itemname]) . "' and section='" . $r['section'] . "' and accountid='" . $_REQUEST['accountcode'] . "' ")->queryScalar();
								$budgets	+= $budget;
								$reallocs += $realloc;
								$commits 	+= $commit;
								$pendings	+= $pending;
								$balances	+= $balance;
						?>
								<tr class=<?= ($ctr % 2 == 0 ? "odd" : "even") ?>>
									<td>
										<?= CHtml::link($r2['itemname'], $this->createAbsoluteUrl('bcItembudgets/accountcodes', array('accountcode' => $_REQUEST['accountcode'], 'section' => $r['section'], 'item' => $r2['item']))); ?>
									</td>
									<td style='text-align:right;'><?= number_format($budget); ?></td>
									<td style='text-align:right;'><?= number_format($realloc); ?></td>
									<td style='text-align:right;'><?= number_format($commit); ?></td>
									<td style='text-align:right;'><?= number_format($pending); ?></td>
									<td style='text-align:right;'><?= number_format($balance); ?></td>
								</tr>


							<?php		} ?>
							<tr>
								<td style='text-align:left;font-weight:bold'><?= $r['dept'] ?> - <?= $r['sectionname'] ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($budgets); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($reallocs); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($commits); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($pendings); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($balances); ?></td>
							</tr>


						<?php } ?>

					</tbody>
				</table>
			</div>
		<?php } ?>




		<?php
		if ($model && $_REQUEST['costcentre'] && !$_REQUEST['item'] && !$_REQUEST['accountcode']) {
			//echo "we";
			$sql = "select distinct section,sectionname,dept from v_bc_itembudgets where budget='" . budget() . "'  and accountcode like '" . $_REQUEST['costcentre'] . "%' ";
			if ($_REQUEST['section']) 	$sql .= " and section=" . $_REQUEST['section'];
			//$sql .=" order by dept,sectionname";
			//echo $sql;
			//exit;
			$rawData = Yii::app()->db->createCommand($sql)->queryAll();
		?>
			<h3>Budget History for Cost Centre</h3>

			<div id='foo' class='grid-view'>
				<table class="items">
					<thead>
						<tr>
							<th id="bc-itembudgets-grid_c0">Section</th>
							<th id="bc-itembudgets-grid_c1">Budget</th>
							<th id="bc-itembudgets-grid_c2">Re-Allocations</th>
							<th id="bc-itembudgets-grid_c3">Committed</th>
							<th id="bc-itembudgets-grid_c4">Pending</th>
							<th id="bc-itembudgets-grid_c5">Balance</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($rawData as $r) {
						?>
							<tr>
								<td colspan=6 style='text-align:left;font-weight:bold'><?= $r['dept'] ?> - <?= $r['sectionname'] ?></td>

							</tr>

							<?php

							$sql2 = "select distinct accountcode,accountitem,accountid from v_bc_itembudgets where section='" . $r['section'] . "' and budget='" . budget() . "'  and accountcode like '" . $_REQUEST['costcentre'] . "%' order by accountcode";
							$rawData2 = Yii::app()->db->createCommand($sql2)->queryAll();
							$ctr = $commits = $reallocs = $budgets = $pendings = $balances = 0;
							foreach ($rawData2 as $r2) {
								$ctr++;
								//echo "Select sum(amount) from v_bc_itembudgets where budget=".budget()." and accountcode like '".$_REQUEST['costcentre']."%' and section='".$r['section']."'  and reason in (1)";
								//exit;
								$budget = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and accountcode = '" . $r2['accountcode'] . "' and section='" . $r['section'] . "'  and reason in (1)")->queryScalar();
								$realloc = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and accountcode = '" . $r2['accountcode'] . "'  and section='" . $r['section'] . "'  and reason in (2,5,4)")->queryScalar();
								$commit = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and accountcode = '" . $r2['accountcode'] . "'  and section='" . $r['section'] . "' and  `status`='COMMITED' and reason in (3,6)")->queryScalar();
								$pending = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and accountcode = '" . $r2['accountcode'] . "'  and section='" . $r['section'] . "' and  `status`='PENDING' and  reason in (3,6)")->queryScalar();
								$balance = Yii::app()->db->createCommand("Select sum(amount) from v_bc_itembudgets where budget=" . budget() . " and  accountcode = '" . $r2['accountcode'] . "'  and section='" . $r['section'] . "'")->queryScalar();
								//	echo "Select sum(amount) from v_bc_itembudgets where budget=".budget()." and  accountcode='".$_REQUEST['costcentre']."%' and section='".$r['section']."'";
								$budgets	+= $budget;
								$reallocs += $realloc;
								$commits 	+= $commit;
								$pendings	+= $pending;
								$balances	+= $balance;

								$tbudgets	+= $budget;
								$treallocs += $realloc;
								$tcommits 	+= $commit;
								$tpendings	+= $pending;
								$tbalances	+= $balance;

							?>
								<tr class=<?= ($ctr % 2 == 0 ? "odd" : "even") ?>>
									<td>
										<?= CHtml::link($r2['accountcode'] . " - " . $r2['accountitem'], $this->createAbsoluteUrl('bcItembudgets/accountcodes', array('accountcode' => $r2['accountid'], 'section' => $r['section'], 'item' => $r2['item']))); ?>
									</td>
									<td style='text-align:right;'><?= number_format($budget); ?></td>
									<td style='text-align:right;'><?= number_format($realloc); ?></td>
									<td style='text-align:right;'><?= number_format($commit); ?></td>
									<td style='text-align:right;'><?= number_format($pending); ?></td>
									<td style='text-align:right;'><?= number_format($balance); ?></td>
								</tr>


							<?php		} ?>
							<tr>
								<td style='text-align:left;font-weight:bold'><?= $r['dept'] ?> - <?= $r['sectionname'] ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($budgets); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($reallocs); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($commits); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($pendings); ?></td>
								<td style='text-align:right;font-weight:bold'><?= number_format($balances); ?></td>
							</tr>


						<?php } ?>
						<tr>
							<td style='text-align:left;font-weight:bold;font-size:12px'>Grand Total</td>
							<td style='text-align:right;font-weight:bold;font-size:12px'><?= number_format($tbudgets); ?></td>
							<td style='text-align:right;font-weight:bold;font-size:12px'><?= number_format($treallocs); ?></td>
							<td style='text-align:right;font-weight:bold;font-size:12px'><?= number_format($tcommits); ?></td>
							<td style='text-align:right;font-weight:bold;font-size:12px'><?= number_format($tpendings); ?></td>
							<td style='text-align:right;font-weight:bold;font-size:12px'><?= number_format($tbalances); ?></td>
						</tr>

					</tbody>
				</table>
			</div>
		<?php } ?>
		<?php if (!$_REQUEST['print']) echo "<a href='" . $_SERVER['REQUEST_URI'] . "&print=1'>View in Report/Print</a>"; ?>

		</div>
</center>