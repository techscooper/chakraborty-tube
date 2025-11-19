<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../assets/vendor/jquery-sparkline/js/jquery.sparkline.min.js"></script>
<script src="../assets/bundles/c3.bundle.js"></script>
<script src="../assets/bundles/jvectormap.bundle.js"></script>
<script src="../assets/js/theme.js"></script>
<script src="../assets/vendor/toast/js/popper.min.js"></script>
<script src="../assets/vendor/toast/js/bootstrap.min.js"></script>
<script src="../assets/vendor/toast/js/toast.js"></script>
<script>
function toast(type,title,subtitle,content)		//TYPES = ['info', 'warning', 'success', 'error'];
{
	$.toast({
		title: title,
		subtitle: subtitle,
		content: content,
		type: type,
		pause_on_hover: false,
		delay: 2500
	});
}
</script>
<!-- Modal -->
<div class="modal" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div id="div_lightbox"></div>
</div>
<script type="text/javascript">
//onkeypress="return check(event)"
function check(evt){
	evt =(evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode > 31 && (charCode < 48 || charCode > 57)){return false;}
}

//onkeypress="return check(event)"
function check(evt){
	evt =(evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode > 31 && (charCode < 48 || charCode > 57)){return false;}
}

//onkeypress="return check3(event)"
function check3(evt){
	evt =(evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode==32){return false;}
}

function spotUpdate1(sl,fn,fv,div,tblnm){
	$("#"+div).load("../spot-update.php?sl="+sl+"&fn="+fn+"&fv="+encodeURI(fv)+"&div="+div+"&tblnm="+tblnm).fadeIn('fast');
}
function spotUpdate2(sl,fn,fv,div,tblnm){
	$("#"+div).load("../spot-updates.php?sl="+sl+"&fn="+fn+"&fv="+encodeURI(fv)+"&div="+div+"&tblnm="+tblnm).fadeIn('fast');
}
</script>