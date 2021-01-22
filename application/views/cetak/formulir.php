<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style type="text/css">
        .container {margin-right: auto; margin-left: auto; padding-left: 25px; padding-right: 25px;}
        .row {margin-left: -5px; margin-right: -15px;}
        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {float: left;}
        .col-md-12 {width: 100%;}
        .col-md-11 {width: 91.66666667%;}
        .col-md-10 {width: 83.33333333%;}
        .col-md-9 {width: 75%;}
        .col-md-8 {width: 66.66666667%;}
        .col-md-7 {width: 58.33333333%;}
        .col-md-6 {width: 50%;}
        .col-md-5 {width: 41.66666667%;}
        .col-md-4 {width: 33.33333333%;}
        .col-md-3 {width: 25%;}
        .col-md-offset-7 {margin-left: 58.33333333%;}
        .col-md-2 {width: 16.66666667%;}
        .col-md-1 {width: 8.33333333%;}
        .text-center {text-align: center;}
        .thumbnail {display: block;padding: 4px;margin-bottom: 20px;line-height: 1.42857143;background-color: #ffffff;border: 1px solid #dddddd;border-radius: 4px;-webkit-transition: border 0.2s ease-in-out;-o-transition: border 0.2s ease-in-out;transition: border 0.2s ease-in-out;}
        hr.style-eight {
            overflow: visible; /* For IE */
            padding: 0;
            border: none;
            border-top: medium double #333;
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <div style="width: 100%;" class="text-center">
        <img src="<?=base_url("assets/img/kop.PNG");?>" style="width:85%;" />
        <hr style="border:1px solid black; width:85%;" />
    </div>
<div style="margin-left:60px; margin-right:60px; line-height: 1.6;">
    <div class="row">
        <div class="text-center" style="font-size: 16px; font-weight: bold;">
            FORMULIR BEASISWA<br>
            PENINGKATAN PRESTASI AKADEMIK (PPA)<br>
            TAHUN ANGGARAN 2020
        </div>
    </div>
    <div class="row">
        <table style="font-family: Times New Roman; font-size: 16px">
            <tr>
                <th align="left">Nama Mahasiswa</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->nama?></td>
            </tr>
            <tr>
                <th align="left">NIM</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->nim?></td>
            </tr>
            <tr>
                <th align="left">Jenis Kelamin</th>
                <td> : </td>
                <td><?=($mahasiswa->data->mahasiswa->jk=='L')?'Laki-laki':'Perempuan';?></td>
            </tr>
            <tr>
                <th align="left">Tempat, Tanggal Lahir</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->tmpt_lahir?>, <?=$mahasiswa->data->mahasiswa->tgl_lahir?></td>
            </tr>
            <tr>
                <th align="left">Alamat Tempat Tinggal</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->jln?></td>
            </tr>
            <!-- <tr>
                <th align="left">&nbsp;</th>
                <td>&nbsp;</td>
                <td>Kota _________________ Provinsi __________________</td>
            </tr> -->
            <tr>
                <th align="left">&nbsp;</th>
                <td>&nbsp;</td>
                <td>Kode Pos <?=$mahasiswa->data->mahasiswa->kode_pos?> Telp / HP <?=$mahasiswa->data->mahasiswa->telepon_rumah?> / <?=$mahasiswa->data->mahasiswa->telepon_seluler?></td>
            </tr>
            <tr>
                <th align="left">Nama Perguruan Tinggi</th>
                <td> : </td>
                <td>UIN SUNAN GUNUNG DJATI BANDUNG</td>
            </tr>
            <tr>
                <th align="left">Fakultas</th>
                <td> : </td>
                <td><?=$tblSFakultas->fakultas?></td>
            </tr>
            <tr>
                <th align="left">Jurusan</th>
                <td> : </td>
                <td><?=$mahasiswa->data->jurusan->nama_jur?></td>
            </tr>
            <tr>
                <th align="left">Semester</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->status_semester?></td>
            </tr>
            <tr>
                <th align="left">Indek Prestasi Terakhir</th>
                <td> : </td>
                <td><?=$ipk[0]->ipk?></td>
            </tr>
            <!-- <tr>
                <th align="left">Rekening Bank Syari'ah Mandiri</th>
                <td> : </td>
                <td>-</td>
            </tr> -->
            <tr>
                <th align="left">Nama Ayah Kandung</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->nm_ayah?> (<?=$tblOrangtua->status_ayah?>) <a href="#" data-toggle="modal" data-target="#ubah_status_ayah" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a></td>
            </tr>
            <tr>
                <th align="left">Nama Ibu Kandung</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->nm_ibu_kandung?> (<?=$tblOrangtua->status_ibu?>) <a href="#" data-toggle="modal" data-target="#ubah_status_ibu" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a></td>
            </tr>
            <tr>
                <th align="left">Pekerjaan Orangtua</th>
                <td> : </td>
                <td><?=$mahasiswa->data->mahasiswa->pekerjaan_ayah?></td>
            </tr>
            <tr>
                <th align="left">Alamat Orangtua</th>
                <td> : </td>
                <td><?=$tblOrangtua->alamat?> <a href="#" data-toggle="modal" data-target="#ubah_alamat_orangtua" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a></td>
            </tr>
            <tr>
                <th align="left">&nbsp;</th>
                <td>&nbsp;</td>
                <td><?=$tblOrangtua->kabupaten?> Provinsi <?=$tblOrangtua->provinsi?></td>
            </tr>
            <tr>
                <th align="left">&nbsp;</th>
                <td>&nbsp;</td>
                <td>Kode Pos <?=$tblOrangtua->kode_pos?> Telp <?=$tblOrangtua->telepon_rumah?> / HP <?=$tblOrangtua->telepon_seluler?></td>
            </tr>
        </table>
    </div>
    <div>
        <p style="font-family: Times New Roman; font-size: 16px">Saya bertanggung jawab atas kebenaran pernyataan tersebut diatas;<br>Saya berjanji akan mematuhi semua peraturan dan ketentuan yang telah ditetapkan.</p>
    </div>
    <div class="row">
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4">
            Bandung, <?=date('d F Y')?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            Mengetahui / Menyetujui :<br>
            WD. III,<br>
            <br>
            <br>
            <br>
            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
            NIP. 
        </div>
        <div class="col-md-4 text-center">
            <br>
            <img src="<?=base_url()?>uploads/<?=date('Y')?>/file/<?=$tblFileFoto->file?>" width="100" height="130">
        </div>
        <div class="col-md-4">
            Pemohon,<br>
            <br>
            <br>
            <br>
            <br>
            <u><?=$mahasiswa->data->mahasiswa->nama?></u>
        </div>
    </div>
</div>
<script>
    window.print()
</script>
</body>
</html>
