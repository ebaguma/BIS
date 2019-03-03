<div class="content">
    <?php
    /* @var $this SlaController */
    ?>
 
    <p>
        Example form of a one to many models with dynamic inputs!
    </p>
    <?php
    $form = $this->beginWidget('DynamicTabularForm', array(
        'defaultRowView'=>'_rowForm',
    ));
    echo "<h3>Header</h3>";
    echo $form->errorSummary($sla);
    ?>
    <div class="row-fluid">
        <div class="span4">
            <?php
            echo $form->labelEx($sla, 'name');
            echo $form->textField($sla, 'name');
            echo $form->error($sla, 'name');
            ?>
        </div>
 
        <div class="span4">
            <?php
            echo $form->labelEx($sla, 'customer_id');
            echo $form->dropDownList($sla, 'customer_id', Customer::getList());
            echo $form->error($sla, 'customer_id');
            ?>
        </div>
        <div class="span4">
            <?php
            echo $form->labelEx($sla, 'owner_id');
            echo $form->dropDownList($sla, 'owner_id', User::getList());
            echo $form->error($sla, 'owner_id');
            ?>
        </div>
 
    </div>
    <h3>Details</h3>
<?php
/**
 * this is the main feature!!
 */
echo $form->rowForm($sladetails);
 
echo CHtml::submitButton('create');
 
$this->endWidget();
?>
</div>