<?php
/* @var $this BcBudgetapprovalsController */
/* @var $model BcBudgetapprovals */

$this->breadcrumbs=array(
	'Bc Budgetapprovals'=>array('index'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'Create BcBudgetapprovals', 'url'=>array('create')),
	array('label'=>'Back to List', 'url'=>array('admin')),
);
?>

<h1>View BcBudgetapprovals #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request',
		'approver',
		'decision',
		'approverdate',
		'comments',
		'approvallevel',
		'nextapprover',
		'nextapprover_role',
		'nextapprover_level',
		'nextapprover_done',
	),
)); ?>

	<section id="cd-timeline" class="cd-container">

		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-picture">
				<img src="images/tm_hos.png" alt="Picture">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content">
				<h2>Title of section 1</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>
				<a href="#0" class="cd-read-more">Read more</a>
				<span class="cd-date">Jan 14</span>
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->
	</section> <!-- cd-timeline -->