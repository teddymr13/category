function checkSubmit(){
    let err = '';
    let flagerr = 0;

    const category_name = document.getElementById('category_name').value;
    if(category_name == ''){
        err = err + '- Please Enter Category!<br/>';
        flagerr = 1;
    }

    if(flagerr === 1){
        showAlert(err, 'danger', 'Incomplete!');
        return false;
    }
    else if(flagerr === 0){
        document.getElementById('form_category').action = '';
        return true;
    }
}
(function () {
    watchFormChange('form_category');
    addFormSubmitListener('form_category');
})();