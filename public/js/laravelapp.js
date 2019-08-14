$(document).ready(function(){
    //Alert Sliding
    $('div.alert').not('.alert_important').delay(3000).slideUp(300);

    //Hapus select dengan empty value dari URL
    $("#form-pencarian").submit(function(){
        $("#id_kelas option[value='']").attr("disabled","disabled");
        $("#jenis_kelamin option[value='']").attr("disabled",'disabled');

        //Pastikan proses submit masih diteruskan
        return true;
    });
});

