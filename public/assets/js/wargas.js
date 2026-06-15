const Toast = Swal.mixin({
    iconColor: "white",
    customClass: {
        popup: "colored-toast",
    },
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

function setMessage(message, status) {
    Toast.fire({
        icon: status,
        title: message,
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        toast: true,
        position: "top-end",
    });
}

$(".buttonDeleteWarga").on("click", function () {
    const code = $(this).data("code");
    const name = $(this).data("name");
    $("#codeDeleteWarga").val(code);
    $(".namaWargaDelete").html(
        "Hapus warga atas nama <strong>" + name + "</strong> ?"
    );
    $("#deleteWarga").modal("show");
});

// $(".buttonEditWarga").on("click", function () {
//     const code = $(this).data("code");
//     const nik = $(this).data("nik");
//     const nama = $(this).data("nama");
//     const alamat = $(this).data("alamat");
//     const jk = $(this).data("jk");
//     const desa =$(this).data("desa");
//     const statusNarkoba =$(this).data("statusNarkoba");
//     const kecamatan = $(this).data("kecamatan");
//     $("#codeEditWarga").val(code);
//     $("#nama").val(nama);
//     $("#alamat").val(alamat);
//     $("#nik").val(nik);
//     $("#desa").val(desa).change();
//     $("#statusNarkoba").val(statusNarkoba);
//     $("#kecamatan").val(kecamatan).change();

//     jk == "Laki-Laki"
//         ? $("#jk #laki-laki").attr("selected", true)
//         : $("#jk #perempuan").attr("selected", true);
//     $("#formModalAdminEditWarga").modal("show");
// });

$(".buttonEditWarga").on("click", function () {
    const code = $(this).data("code");
    const nik = $(this).data("nik");
    const nama = $(this).data("nama");
    const alamat = $(this).data("alamat");
    const jk = $(this).data("jk");
    const desa = $(this).data("desa"); // ID Desa yang akan dipilih
    const kecamatan = $(this).data("kecamatan"); // ID Kecamatan yang akan dipilih
    const status_narkoba = $(this).data("status_narkoba");
    const golongan = $(this).data("golongan");
    const jenis_golongan = $(this).data("jenis_golongan");

    // Set nilai pada form
    $("#codeEditWarga").val(code);
    $("#nama").val(nama);
    $("#alamat").val(alamat);
    $("#nik").val(nik);
    $("#status_narkoba").val(status_narkoba);

    // Pilih Kecamatan & Load Desa Sesuai
    $("#kecamatan").val(kecamatan).change();

    // Tunggu kecamatan terpilih, lalu load desa
    setTimeout(function () {
        loadDesa(kecamatan, desa);
    }, 20); // Delay 500ms agar desa bisa termuat setelah kecamatan berubah

// Setelah mengatur nilai golongan
$("#golongan").val(golongan).trigger("change");

// Tunggu golongan terpilih, baru set jenis_golongan
setTimeout(() => {
    $("#jenis_golongan").val(jenis_golongan);
}, 50);


    // Pilih Jenis Kelamin
    if (jk === "Laki-Laki") {
        $("#jk option[value='Laki-Laki']").prop("selected", true);
    } else {
        $("#jk option[value='Perempuan']").prop("selected", true);
    }
    if (status_narkoba === "Belum Diketahui") {
        $("#status_narkoba option[value='Belum Diketahui']").prop("selected", true);
    } else if (status_narkoba === "Negatif Narkoba") {
        $("#status_narkoba option[value='Negatif Narkoba']").prop("selected", true);
    } else {
        $("#status_narkoba option[value='Positif Narkoba']").prop("selected", true);
    }


    // Tampilkan modal edit
    $("#modalEditWarga").modal("show");
});
$(document).ready(function () {
    $(".modalEditWarga").on("submit", function (e) {
        let code = $("#codeEditWarga").val();
        console.log("Mengirim form dengan code:", code);
    });
});

// Fungsi untuk Memuat Desa berdasarkan Kecamatan
function loadDesa(kecamatan_id, selectedDesa = null) {
    if (kecamatan_id) {
        $.ajax({
            url: "/get-desa/" + kecamatan_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                var desaDropdown = $("#desa");
                desaDropdown.empty();
                desaDropdown.append('<option value="" disabled>Pilih Desa</option>');

                $.each(data, function (key, desa) {
                    let selected = desa.id == selectedDesa ? "selected" : "";
                    desaDropdown.append(
                        '<option value="' + desa.id + '" ' + selected + '>' +
                        desa.nama_desa + '</option>'
                    );
                });

                // Pilih desa sebelumnya jika tersedia
                if (selectedDesa) {
                    desaDropdown.val(selectedDesa).change();
                }
            },
            error: function () {
                alert("Gagal mengambil data desa. Coba lagi!");
            }
        });
    }
}



// $(".buttonEditWarga").on("click", function () {
//     const code = $(this).data("code");
//     const nik = $(this).data("nik");
//     const name = $(this).data("name");
//     const alamat = $(this).data("alamat");
//     const kecamatanId = $(this).data("kecamatan");
//     const desaId = $(this).data("desa");
//     const jk = $(this).data("jk");
//     const status_narkoba = $(this).data("status_narkoba");
//     $("#codeEditWarga").val(code);
//     $("#nik").val(nik);
//     $("#nama").val(name);
//     $("#alamat").val(alamat);

//     // Set Kecamatan jika ada data
//     if (kecamatanId) {
//         $("#kecamatan_id").val(kecamatanId).change();
//     }

//     // Set Desa jika ada data
//     if (desaId) {
//         $("#desa_id").val(desaId).change();
//     }

//     // Set Jenis Kelamin
//     $("#jk").val(jk).change();
//     $("#status").val(status_narkoba).change();


//     $("#formModalAdminEditWarga").modal("show");
// });


$(".cancelModalTambahWarga").on("click", function () {
    $(".modalAdminAddWarga")[0].reset();
    $(
        "#formModalAdminAddWarga #nik, #formModalAdminAddWarga #nama, #formModalAdminAddWarga #kecamatan_id, #formModalAdminAddWarga #jk, #formModalAdminAddWarga #desa_id, #formModalAdminAddWarga #alamat"
    ).removeClass("is-invalid");
    $(
        "#formModalAdminAddWarga #nik, #formModalAdminAddWarga #nama, #formModalAdminAddWarga #kecamatan_id, #formModalAdminAddWarga #jk, #formModalAdminAddWarga #desa_id, #formModalAdminAddWarga #alamat"
    ).removeClass("invalid-feedback");
});
