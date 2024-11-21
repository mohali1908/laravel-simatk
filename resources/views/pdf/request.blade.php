<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Invoice</title>
  <style type="text/css">
    table.page_header {
      width: 100%;
      border: none;
      background-color: #DDDDFF;
      border-bottom: solid 1mm #AAAADD;
      padding: 2mm;
    }
    table.page_footer {
      width: 100%;
      border: none;
      background-color: #DDDDFF;
      border-top: solid 1mm #AAAADD;
      padding: 2mm;
    }
    .tabel2 {
      border-collapse: collapse;
      width: 100%;
      margin: 10px 0;
      font-size: 12px; /* Set font size for table content */
    }
    .tabel2 th {
    padding: 8px;
    text-align: center;
    border: 1px solid #000;
    font-weight: bold; /* Membuat teks tebal */
    font-size: 14px; /* Ukuran font lebih besar untuk header */
    background-color: #f2f2f2; /* Opsional: Memberi warna latar belakang pada header */
    }

    .tabel2 td {
        padding: 8px;
        text-align: center;
        border: 1px solid #000;
        font-weight: normal; /* Teks normal untuk isi tabel */
        font-size: 12px; /* Ukuran font untuk isi tabel */
    }
    .keterangan-table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      font-size: 12px; /* Set font size for keterangan content */
    }
    .keterangan-table td {
      padding: 10px;
      text-align: left;
    }
    table.signature-table {
      width: 100%;
      margin-top: 50px;
      border-collapse: collapse;
    }
    table.signature-table td {
      width: 50%;
      text-align: left;
      vertical-align: top;
      padding: 20px;
    }
    .signature-name {
      margin-top: 50px;
      font-weight: bold;
      text-decoration: underline;
    }
    .small-text {
        font-size: 11px; /* Ukuran font kecil */
    }
    p {
      font-size: 12px; /* Set font size for paragraphs */
    }
  </style>
</head>
<body>
  <table class="page_header">
    <tr>
      <th><img src="logo/pa-cilegon.png" style="width:100px;height:100px" /></th>
      <td align="center" style="vertical-align: top;">
        <p style="font-weight: bold; font-size: 18px; margin: 0;">
            MAHKAMAH AGUNG REPUBLIK INDONESIA<br>
            DIREKTORAT JENDERAL BADAN PERADILAN AGAMA<br>
            PENGADILAN TINGGI AGAMA BANTEN<br>
            PENGADILAN AGAMA CILEGON KELAS 1B
        </p>
        <p style="font-size: 10px; margin: 5px 0 0 0;">
            Kompleks Perkantoran Sukmajaya Mandiri, Jalan Jenderal Ahmad Yani Kav.5, <br>
             Sukmajaya, Kec. Jombang, Kota Cilegon, Banten 42411<br>
            Website: <a href="https://www.pa-cilegon.go.id" target="_blank">https://www.pa-cilegon.go.id</a> / Email: pa_clg@yahoo.com
        </p>
      </td>
    </tr>
  </table>
  <hr>
  <p align="center" style="font-weight: bold; text-decoration: underline; font-size: 16px;">BUKTI PERMINTAAN BARANG (BPP)</p>
  

  <table class="tabel2">
    <thead>
      <tr>
        <th width="10%">No.</th>
        <th width="40%">Produk</th>
        <th width="20%">Unit</th>
        <th width="20%">Jumlah</th>
      </tr>
    </thead>
    <tbody>

      @foreach($allData as $request)
        <tr>
          <td>{{ $key + 1 }}</td>
          <td>{{ $request->product_name}}</td>
          <td>{{ $request->unit_name}}</td>
          <td>{{ $request->quantity}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- Tabel Keterangan dan Tanggal -->
  <table class="keterangan-table">
    <tr>
      <td><b>Keterangan:</b> <span></span></td>
      <td> <span></span></td>
      <td align="right"><b>Tempat/Tanggal Dibuat:</b><br> <span>Cilegon, {{ date('d-m-Y') }}</span></td>
    </tr>
  </table>

   <!-- Tanda Tangan -->
  <table class="signature-table">
    <tr>
      <td>
        <p>Diminta Oleh :</p>
        @foreach($userData as $user)
        <p class="signature-name">{{ $user->user_name }}</p>
        @endforeach
      </td>
      <td>
        <p>Disetujui Oleh :</p>
        <p class="signature-name">Uchtina Dewi</p>
      </td>
    </tr>
    <tr>
      <td colspan="1">
        <p>Dikeluarkan Oleh :</p>
        <p class="signature-name">Hikmah Nurmala, S.H., MH</p>
      </td>
     
    </tr>
  </table>
</body>
</html>
