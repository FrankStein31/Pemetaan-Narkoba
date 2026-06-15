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

// $(".buttonEditSosialisasi").on("click", function () {
//     const code = $(this).data("code");
//     const judul = $(this).data("judul");
//     const deskripsi = $(this).data("deskripsi");
//     $("#codeEditSosialisasi").val(code);
//     $("#judul").val(judul);
//     $("#deskripsi").val(deskripsi);

//     $("#formModalAdminEditSosialisasi").modal("show");
// });
// Contoh JavaScript untuk mengisi form edit
function editSosialisasi(code, judul, deskripsi, gambarPath) {
    document.getElementById('codeEditSosialisasi').value = code;
    document.getElementById('judul').value = judul;
    document.getElementById('deskripsi').value = deskripsi;

    // Set preview gambar
    if (gambarPath) {
        document.getElementById('preview_gambar').src = '/storage/' + gambarPath;
    } else {
        document.getElementById('preview_gambar').src = ''; // Kosongkan jika tidak ada gambar
    }
}
$(".buttonEditSosialisasi").on("click", function () {
    const code = $(this).data("code");
    const judul = $(this).data("judul");
    const deskripsi = $(this).data("deskripsi");
    const desa = $(this).data("desa"); // ID Desa yang akan dipilih
    const kecamatan = $(this).data("kecamatan"); // ID Kecamatan yang akan dipilih
    const gambar = $(this).data("gambar");

    // Set nilai form
    $("#codeEditSosialisasi").val(code);
    $("#judul").val(judul);
    $("#deskripsi").val(deskripsi);
    $("#kecamatan").val(kecamatan).change();

    // Tunggu kecamatan terpilih, lalu load desa
    setTimeout(function () {
        loadDesa(kecamatan, desa);
    }, 20);

    $("#preview_gambar").attr("src", gambar);

    $("#formModalAdminEditSosialisasi").modal("show");
});
$(document).ready(function () {
    $(".modalAdminEditSosialisasi").on("submit", function (e) {
        let code = $("#codeEditSosialisasi").val();
        console.log("Mengirim form dengan code:", code);
    });
});
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

$(".buttonDeleteSosialisasi").on("click", function () {
    const code = $(this).data("code");
    const judul = $(this).data("judul");
    $("#codeDeleteSosialisasi").val(code);
    $(".judulSosialisasiDelete").html(
        "Hapus sosialisasi berjudul <strong>" + judul + "</strong> ?"
    );
    $("#deleteSosialisasi").modal("show");
});

const tambahSosialisasi = $(".flash-message").data(
    "flash-message-sosialisasi"
    );
    if (tambahSosialisasi) {
    setMessage(tambahSosialisasi, "success");
    }
    const deleteSosialisasi = $(".flash-message").data(
    "delete-sosialisasi"
    );
    if (deleteSosialisasi) {
    setMessage(deleteSosialisasi, "success");
    }
    const editSosialisasiSukses = $(".flash-message").data(
        "edit-sosialisasi"
    );
    if (editSosialisasiSukses) {
        setMessage(editSosialisasiSukses, "success");
    }

// $(document).on('click', '.buttonDeleteSosialisasi', function () {
//     let code = $(this).data('code');
//     let judul = $(this).data('judul');

//     $('#codeDeleteSosialisasi').val(code); // Pastikan id sudah terenkripsi sebelum dikirim
//     $('.judulSosialisasiDelete').text(`Apakah Anda yakin ingin menghapus "${judul}"?`);
// });
$(".cancelModalSosialisasi").on("click", function () {
    $(".modalAdminAddSosialisasi")[0].reset();
    $(
        "#formModalSosialisasi #judul, #formModalSosialisasi #deskripsi, #formModalSosialisasi #kecamatan_id, #formModalSosialisasi #desa_id, #formModalSosialisasi #gambar, #formModalSosialisasi #status"
    ).removeClass("is-invalid");
    $(
        "#formModalSosialisasi #judul, #formModalSosialisasi #deskripsi, #formModalSosialisasi #kecamatan_id, #formModalSosialisasi #desa_id, #formModalSosialisasi #gambar, #formModalSosialisasi #status"
    ).removeClass("invalid-feedback");
});
