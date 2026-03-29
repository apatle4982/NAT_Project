//**********************************
//  check-IN search_records, QC index page not include this JS
//********************************//

$(document).ready(function () {
	//$('.disabledColor').find("input[type='checkbox']").attr("disabled", true);
	
	/* $('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green'
	});

	// for top select box  // :first
	$("select").not('#archieve').select2();
	
	$(".navbar").on("mouseenter",function(){
		$("select").not('#archieve').select2().trigger("close"); 
	});
	
	$('#btnReset').click(function() {
		$("select").val(null).trigger("change"); 
	});
	
	$('#datepicker, #datepicker1, #datepicker2, #datepicker3, #datepicker4, #datepicker5, #datepicker6, #datepicker7').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true, 
		//dateFormat: 'yy-mm-dd'
	}); */

	$("#checkedAll").change(function(){  
		if(this.checked){
			$(".checkSingle").not(':disabled').each(function(){
				this.checked=true;
			})  
		            
		}else{
			$(".checkSingle").each(function(){
				this.checked=false;
			})              
		}
	});
	
	$(".checkSingle").click(function () {
		if ($(this).is(":checked")){
			var isAllChecked = 0;
			$(".checkSingle").each(function(){
				if(!this.checked)
				isAllChecked = 1;
			})              
			if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }     
		}else {
			$("#checkedAll").prop("checked", false);
		}
	});

	/* 
	var table = $('#datatable_example').DataTable();
	new $.fn.dataTable.Buttons( table, {
		buttons:["csv","excel", "pdf"]
	} );

	table.buttons( 0, null ).container().prependTo(
		table.table().container()
	); */

	
	
});

function getSerializeFormData(elementIdentifier = '#myForm'){
	// Serialize the form data into an array of objects
	let formDataArray = $(elementIdentifier).serializeArray();

	// Convert the array of objects into a key-value object
	let formDataObject = {};
	$.each(formDataArray, function(i, field) {
	  formDataObject[field.name] = field.value;
	});
  
	//console.log(formDataObject);
	return formDataObject;
}