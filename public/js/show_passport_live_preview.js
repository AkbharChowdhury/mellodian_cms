$(document).ready(function () {
    if($('#customerPassportImage').val()){
        $('#customerImage').attr('src', $('#customerPassportImage').val());
        $('#imageDiv').attr('style','visible');
    }

    $("#passport_image").change(function () {
        $('#imageDiv').attr('style','visible');

        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#customerImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    const chkPassword = document.querySelector('#togglePassword');
    const password = document.getElementById('password')
    if (chkPassword) chkPassword.addEventListener('change', (e) => (password.type = e.target.checked ? 'text' : 'password'));
});