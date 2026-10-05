/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// fungsi hapus Stisla modal
function hapus(id) {
    $('#del-' + id).submit();
}

// menu dinamis
var path = location.pathname.split('/');
var url = location.origin + '/' + path[1];
$('ul.sidebar-menu li a').each(function () {
    if ($(this).attr('href').indexOf(url) !== -1) {
        $(this).parent().addClass('active').parent().parent('li').addClass('active');
    }
});

// pagination
$(document).ready(function () {
    $('#myTable').DataTable();
});

// Cache data akun3 dan status agar form dinamis instan tanpa delay
var cachedAkun3 = null;
var cachedStatus = null;

function getAppUrl(endpoint) {
    if (typeof baseUrl !== 'undefined' && baseUrl) {
        var base = baseUrl.replace(/\/+$/, '');
        return base + '/' + endpoint.replace(/^\/+/, '');
    }
    return '/' + endpoint.replace(/^\/+/, '');
}

function FormSelectAkun(Nomor) {
    if (cachedAkun3) {
        renderSelectAkun(Nomor, cachedAkun3);
    } else {
        $.getJSON(getAppUrl('transaksi/akun3'), function (data) {
            cachedAkun3 = data;
            renderSelectAkun(Nomor, cachedAkun3);
        }).fail(function (xhr) {
            console.error('Gagal memuat akun3:', xhr);
        });
    }
}

function renderSelectAkun(Nomor, data) {
    var output = ['<option value="">Pilih Akun</option>'];
    $.each(data, function (key, value) {
        var namaAkun = value.nama_akun3 || value.nama_akun || '';
        output.push('<option value="' + value.kode_akun3 + '">' + value.kode_akun3 + ' | ' + namaAkun + '</option>');
    });
    $('#kode_akun3' + Nomor).html(output.join(''));
}

function FormSelectStatus(Nomor) {
    if (cachedStatus) {
        renderSelectStatus(Nomor, cachedStatus);
    } else {
        $.getJSON(getAppUrl('transaksi/status'), function (data) {
            cachedStatus = data;
            renderSelectStatus(Nomor, cachedStatus);
        }).fail(function (xhr) {
            console.error('Gagal memuat status:', xhr);
        });
    }
}

function renderSelectStatus(Nomor, data) {
    var output = ['<option value="">Pilih Status</option>'];
    $.each(data, function (key, value) {
        output.push('<option value="' + value.id_status + '">' + value.status + '</option>');
    });
    $('#id_status' + Nomor).html(output.join(''));
}

function Barisbaru() {
    var Nomor = $("#tableLoop tbody tr").length + 1;
    var Baris = '<tr>';
    Baris += '<td class="text-center align-middle">' + Nomor + '</td>';
    Baris += '<td>';
    Baris += '<select class="form-control" name="kode_akun3[]" id="kode_akun3' + Nomor + '" required></select>';
    Baris += '</td>';
    Baris += '<td>';
    Baris += '<input type="number" name="debet[]" class="form-control" value="0" min="0" required>';
    Baris += '</td>';
    Baris += '<td>';
    Baris += '<input type="number" name="kredit[]" class="form-control" value="0" min="0" required>';
    Baris += '</td>';
    Baris += '<td>';
    Baris += '<select class="form-control" name="id_status[]" id="id_status' + Nomor + '" required></select>';
    Baris += '</td>';
    Baris += '<td class="text-center align-middle">';
    Baris += '<button type="button" class="btn btn-sm btn-danger font-weight-bold px-2 py-1" id="HapusBaris" title="Hapus Baris"><i class="fas fa-times"></i></button>';
    Baris += '</td>';
    Baris += '</tr>';

    $("#tableLoop tbody").append(Baris);
    $("#tableLoop tbody tr:last").find('td:nth-child(2) select').focus();

    FormSelectAkun(Nomor);
    FormSelectStatus(Nomor);
}

$(document).ready(function () {
    if ($('#tableLoop').length > 0) {
        // Jika tbody masih kosong, tambahkan 2 baris awal (Debit dan Kredit)
        if ($('#tableLoop tbody tr').length === 0) {
            Barisbaru();
            Barisbaru();
        }
        $('#Barisbaru, #BarisBaru').click(function (e) {
            e.preventDefault();
            Barisbaru();
        });
    }
});

$(document).on('click', '#HapusBaris', function (e) {
    e.preventDefault();
    $(this).closest('tr').remove();
    var Nomor = 1;
    $('#tableLoop tbody tr').each(function () {
        $(this).find('td:first').html(Nomor);
        Nomor++;
    });
});