function getStatus(url, id) {
    $.ajax({
        url: `statuses/${id}`,
        type: "GET",
        success: function (data) {
            $("#txtid").val(data.id);
            $("#txtnama").val(data.nama);
        },
        error: function (data) {
            console.log(error); //or whatever
        },
    });
    $("#formStatus").attr("action", url);
    $("#formStatus").attr("method", "POST");
}

function tambahStatus(url) {
    $("#formStatus").attr("action", url);
    $("#formStatus").attr("method", "POST");
    $("#txtid").val("");
    $("#txtnama").val("");
}

const deleteStatus = (val) => {
    pesan = confirm(`${val} Yakin untuk di non aktifkan??`);

    if (pesan) return true;
    return false;
};

const formGudang = () => {
    pesan = confirm(`Yakin untuk di simpan??`);

    if (pesan) return true;
    return false;
};

const tambahAlternatif = (url) => {
    $("#form-alternatif").attr("action", url);
    $("#form-alternatif").attr("method", "POST");
    $("#txtid").val("");
    $("#txtnama").val("");
    $(".btn-alternatif").html("Save");
};

const updateAlternatif = (url, id, nama) => {
    $("#form-alternatif").attr("action", url);
    $("#txtid").val(id);
    $("#txtnama").val(nama);
    $(".btn-alternatif").html("Update");
};
