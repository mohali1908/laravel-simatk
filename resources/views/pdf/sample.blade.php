<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
 
   
    <!-- Setting CSS bagian header/ kop -->
<style type="text/css">
  table.page_header {width: 1020px; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
  table.page_footer {width: 1020px; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
  

</style>
<!-- Setting Margin header/ kop -->
<!-- Setting CSS Tabel data yang akan ditampilkan -->
<style type="text/css">
 .tabel2 {
  border-collapse: collapse;
  margin-left: 5px;
}
.tabel2 th, .tabel2 td {
  padding: 5px 5px;
  border: 1px solid #000;
}
div.kanan {
 position: absolute;
 bottom: 100px;
 right: 50px;

}

div.tengah {
 position: absolute;
 bottom: 100px;
 right: 330px;

}

div.kiri {
 position: absolute;
 bottom: 100px;
 left: 10px;     
}

</style>
   
</head>
<body>
<table>
  <tr>
    <th rowspan="3"><img src="../gambar/smknu3.png" style="width:100px;height:100px" /></th>
    <td align="center" style="width: 520px;"><font style="font-size: 18px"><b>KEMENDIKBUDRISTEK<br>DINAS PENDIDIKAN PROVINSI JAWA TIMUR<br>SMK NU 03 BONDOWOSO</b></font>
      <br>Jl. Niaga Desa Nogosari, Kec. Sukosari, Kab.Bondowoso, Jawa Timur 68287 <br>Telp : (0402) 333333</td>

    </tr>
  </table>
  <hr>
  <p align="center" style="font-weight: bold; font-size: 18px;"><u>LAPORAN PEMASUKAN BARANG</u></p>
  <div class="isi" style="margin: 0 auto;">
   <table class="tabel2">
    <thead>
      <tr>
        <td style="text-align: center; width=10px;"><b>No.</b></td>        
        <td style="text-align: center; width=90px;"><b>Name</b></td>
        <td style="text-align: center; width=150px;"><b>Tanggal</b></td>
        <td style="text-align: center; width=50px;"><b>buying_qty</b></td>
                                        
      </tr>
    </thead>
    <tbody>
    <p>Date Range: {{ $start_date }} to {{ $end_date }}</p>

    @foreach($allData as $key => $purchase)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $purchase->name }}</td>
                    <td>{{ $purchase->date }}</td>
                    <td>{{ $purchase->buying_qty }}</td>
                </tr>
            @endforeach
     

        <tr>
          <td style="text-align: center; font-size: 12px;">{{ $key + 1 }}</td>             
          <td style="text-align: center; font-size: 12px;">{{ $purchase->name }}</td>
          <td style="text-align: left; font-size: 12px;">{{ $purchase->date }}</td>
          <td style="text-align: center; font-size: 12px;">{{ $purchase->buying_qty }}</td>

        </tr>

      

    </tbody>
  </table>
</div>



<!-- <p>Tanggal Pemasukan : <b>  <br> Jumlah Barang :  <br> Total Harga Barang :.- <br> Sub Total :.- </b></p> -->



<div class="kiri">
  <p> </p>
  <p>Diminta Oleh :<br>Bendahara  </p>
  <p></p>
  <p></p>
  <b><p><u>AZIZAH, S.Pd </u><br>NIP: -</p></b>
  <br>
  <br>
  <br>


</div>



<div class="kanan">
  <p></p>
  <p>Disetujui Oleh :<br>Kepala Sekolah </p>
  <p></p>
  <p> </p>
  <b><p><u>HARYANTO, S.Pd </u><br>NIP: -</p></b>
  <br>
  <br>
  <br>

</div>


</body>
</html>
