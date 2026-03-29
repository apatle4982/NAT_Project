function initiateMulti(){ 
    var multiSelectHeader =   document.getElementById("multiselect-optiongroup"),
    
    multiSelectOptGroup = (multiSelectHeader && multi(multiSelectHeader, { 
        selected_header: "Selected Fields" 
    })); 
}

initiateMulti();