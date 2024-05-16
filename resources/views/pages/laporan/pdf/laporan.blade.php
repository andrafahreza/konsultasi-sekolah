<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }

        table {
            font-size: 14px;
        }

        .table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .table thead th {
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 1px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

    </style>
</head>

<body>
    <table style="width: 100%">
        <tr>
            <th>
                <img src="https://smpn1jatinegara.sch.id/wp-content/uploads/2020/10/logo-kemdikbud-ori-300x300.png" style="width: 140px;">
            </th>
            <th style=" font-size: 17px;">
                <center>
                    PEMERINTAHAN KABUPATEN MEDAN <br> DINAS PENDIDIKAN <br> UNIT PELAKSANA DINAS KECAMATAN MEDAN HELVETIA <br> SMP KARYA BHAKTI <br>
                    <span style="font-weight: normal; font-size: 14px">Jl. Mesjid No. 57, Cinta Damai Sumatera Utara, No: 061846308 email : smpskaryabhakti@gmail.com</span>
                </center>
            </th>
            <th>
                <img src="https://smpn1jatinegara.sch.id/wp-content/uploads/2020/10/logo-kemdikbud-ori-300x300.png" style="width: 140px;">
            </th>
        </tr>
    </table> <hr>
    <span> Periode : {{ date('d-m-Y', strtotime($from)) }} s/d {{ date('d-m-Y', strtotime($to)) }} &nbsp; &nbsp; Jumlah konseling: {{ $data->count() }}</span>
    <table class="table table-bordered table-striped" style="text-align: center">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Nama Konselor</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Isi</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->siswa->nik }}</td>
                    <td>{{ $item->siswa->nama_lengkap }}</td>
                    <td>{{ $item->konselor->nama_konselor }}</td>
                    <td>{{ date('d-m-Y H:i:s', strtotime($item->tgl_bk)) }}</td>
                    <td>{{ strtoupper($item->jenis) }}</td>
                    <td>{{ $item->isi }}</td>
                    <td>{{ $item->tindakan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br> <br>

    <table style="width: 100%">
        <tr>
            <td style="text-align: right; font-size: 17px;">Medan, {{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px;">Kepala Sekolah</td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px;"><br><br><br></td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px;">NIP. {{ $kepsek->nip }}</td>
        </tr>
    </table>
</body>

</html>
