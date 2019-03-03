<script>
 
$(document).ready(function() {
    $("#dialog").dialog();
});
 
</script>
 
<style>
 
 
.window {
  position:absolute;
  left:0;
  top:0;
  width:300px !important;
  min-height:160px !important;
  z-index:9999;
  padding:20px;
  border:10px #404040 solid;
  -moz-box-shadow:0px 0px 3px #000;
  -webkit-box-shadow:0px 0px 3px #000;
  box-shadow:0px 0px 15px #000;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
}
.event_viewbx
{
    margin:0px;
    padding:20px;
    position:relative;
    background:url(images/grid_noise.png) repeat;
}
 
.txt_bx{ margin:0px; padding:5px 0px; width:440px;}
.txt_bx span
{
    color: #666666;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 0.001em;
    padding:0px 5px;
}
.ui-corner-all 
{
    position:absolute;
    top:8px;
    right:0px;
    z-index:10000;
    color:#ed827c;
    font-size:12px;
 
 
}
.ui-corner-all a{text-indent:-999px !important; background:url(images/evnt_close.png) no-repeat !important;
    width:12px; height:12px;}
 
 
 
</style>
 
<div id="dialog" class="window">
    <div class="event_viewbx">
    <div class="e_closebttn"></div>
    <div class="txt_bx">
    <span>Time:</span><span><?php echo time();?></span>
    </div>
    <div class="txt_bx">
    <span>Data:</span><span><?php echo $data;?></span>
    </div>
    <div class="txt_bx">
    <span>Description:</span><span>I'm in a dialog</span>
    </div>
 
    </div>
</div>