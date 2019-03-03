<?php
/* @var $this EmployeesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employees',
);

$this->menu=array(
	array('label'=>'Create Employees', 'url'=>array('create')),
	array('label'=>'Manage Employees', 'url'=>array('admin')),
);
?>

<h1>Employees</h1>
<?php

$this->widget('application.extensions.rgraph.RGraphLine', array(
    'data' => array(1, 3, 5, 7, 2, 4, 6, 10, 8, 9, 12, 11),
    'options' => array(
        'chart' => array(
            'gutter' => array(
                'left' => 35,
            ),
            'colors' => array('red'),
            'title' => 'A basic chart',
            'labels' => array(
                'Jan', 'Feb ', 'Mar ', 'Apr ', 'M a y ', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ),
        )
    )
));

?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
