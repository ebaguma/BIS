<style>
.white-popup-block {
    background: #FFF;
    padding: 20px 30px;
    text-align: center;
    max-width: 950px;
    margin: 40px auto;
    position: relative;	
}
.mfp-hide{display:none!important}
#videoo table {border:1px solid black;}
</style>

<a href="#videoo" id="video">Procurement Form 5</a>
<?php
/*
$this->widget("ext.magnific-popup.EMagnificPopup", array(
'target' => '#video',
'type' => 'inline',
));
*/?>

<div id="videoo"  class="mfp-hide white-popup-block"><?php include('form5.php')?></div>

<a class="test-popup-link" href="http://google.com">Open popup</a>

<?php
//$this->widget("ext.magnific-popup.EMagnificPopup", array('target' => '.test-popup-link','type' => 'ajax',));
?>
