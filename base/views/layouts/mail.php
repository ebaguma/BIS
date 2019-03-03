<html>
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="content-type">
</head>
<body>
<table cellspacing="0" cellpadding="10" style="color:#333;font:13px Arial;line-height:1.4em;width:100%;">
	<tbody>
		<tr>
            <!--<td style="color:#4D90FE;font-size:22px;border-bottom: 2px solid #4D90FE;">-->
				<td style="color:#9fc9ff;font-size:22px;border-bottom: 2px solid #9fc9ff;">
				<?php echo CHtml::encode(Yii::app()->name); ?>
            </td>
		</tr>
		<tr>
            <td style="color:#777;font-size:16px;padding-top:5px;">
            	<?php if(isset($data['description'])) echo $data['description'];  ?>
				<!--<?php if(isset($data['name'])) echo $data['name'];  ?>-->
            </td>
		</tr>
		<tr>
            <td>
				<?php if(isset($data['message'])) echo $data['message'];  ?>
            </td>
		</tr>
	</tbody>
</table>
</body>
</html>