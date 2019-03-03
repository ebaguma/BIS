<?php $row_id = "sladetail-" . $key ?>
<div class='row-fluid' id="<?php echo $row_id ?>">
    <?php
    echo $form->hiddenField($model, "[$key]id");
    echo $form->updateTypeField($model, $key, "updateType", array('key' => $key));
    ?>
    <div class="span3">
        <?php
        echo $form->labelEx($model, "[$key]location");
        echo $form->textField($model, "[$key]location");
        echo $form->error($model, "[$key]location");
        ?>
 
    </div>
 
    <div class="span3">
        <?php
        echo $form->labelEx($model, "[$key]remarks");
        echo $form->textField($model, "[$key]remarks");
        echo $form->error($model, "[$key]remarks");
        ?>
    </div>
 
    <div class="span3">
        <?php
        echo $form->labelEx($model, "[$key]schedule");
 
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => "[$key]schedule",
            'options' => array(
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        echo $form->error($model, "[$key]schedule");
        ?>
 
 
    </div>
    <div class="span2">
 
            <?php echo $form->deleteRowButton($row_id, $key); ?>
        </div>
</div>