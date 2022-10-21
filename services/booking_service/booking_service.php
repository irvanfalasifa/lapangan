<?php
$result = get_CURL('http://localhost/booking-service/api/booking');

$booking = $result['data'];

$sukses = "";
$error = "";

if(isset($_GET['op'])){
  $op = $_GET['op'];
}else{
  $op = "";
}
  
if($op == 'delete'){
  $api_url = "http://localhost/booking-service/api/booking";
  $params = [
      'id'=> $_GET['id']
      ];
  CallAPI($api_url, $params);

  if($id){
    $sukses = "Berhasil hapus data";
  }else{
    $error = "Gagal hapus data";
  }
}

if($op == 'edit'){
  $id = $_GET['id'];
  $sql1 = "SELECT * FROM customer WHERE id = $id";
  $q1 = mysqli_query($connect_customer, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $nama = $r1['nama'];
  $no_wa = $r1['no_wa'];
  $alamat = $r1['alamat'];
  if($nama == ''){
  $error = "Data tidak ditemukan";
  }
}

if(isset($_POST['simpan_booking'])){

    foreach ($products as $key) :
        if($_POST['nama_produk'] == $key['nama']){
            $harga = $key['harga'];
        }
    endforeach;

    $total_harga = $harga * $_POST['waktu'];
    $post = [
        'nama' => $_POST['nama_customer'],
        'lapangan' => $_POST['nama_produk'],
        'waktu' => $_POST['waktu'],
        'harga' => $harga,
        'total_harga' => $total_harga,
        'status' => $_POST['status']
    ];
    

    if($post){
        $sukses = "Berhasil memasukan data baru";
        post_CURL('http://localhost/booking-service/api/booking', $post);
    }else{
        $error = "Gagal memasukan data";
    }
}

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
    
if($op == 'hapus'){
  $id = $_GET['id'];

  if($id){
    post_CURL('http://localhost/booking-service/api/booking');
    $sukses = "Berhasil hapus data";
  }else{
    $error = "Gagal hapus data";
  }
}

?>

<h1 class="mb-5 d-inline-block">Booking</h1>

<?php
  if($sukses){
?>
    <div class="alert alert-success" role="alert">
      <?php echo $sukses ?>
    </div>
<?php
    header("refresh:2;url=index.php");
  } 
?>

<?php
  if($error){
?>
    <div class="alert alert-danger" role="alert">
<?php echo $error ?>
    </div>
<?php 
  } 
?>


<form class="row mb-3" action="" method="POST">
      <div class="col">
        <input type="hidden" value="<?php echo $id;?>" name="id">
        <select class="form-select" aria-label="Default select example" name="nama_customer">
            <option selected>Pilih Nama</option>
        <?php
        foreach ($customers as $row) : ?>
            <option value="<?=$row['nama'];?>"><?=$row['nama'];?></option>
        <?php 
        endforeach;
        ?>
        </select>
      </div>
      <div class="col">
        <input type="hidden" value="<?php echo $id;?>" name="id">
        <select class="form-select" aria-label="Default select example" name="nama_produk">
            <option selected>Pilih Product</option>
        <?php
        foreach ($products as $row) : ?>
            <option value="<?=$row['nama'];?>"><?=$row['nama'];?> (<?=$row['deskripsi'];?>)</option>
        <?php 
        endforeach;
        ?>
        </select>
      </div>
      <div class="col">
        <input type="number" class="form-control" placeholder="Waktu" name="waktu">
      </div>

      <div class="col">
    
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="Lunas">
            <label class="form-check-label" for="flexRadioDefault1">
                Lunas
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="Belum Lunas">
            <label class="form-check-label" for="flexRadioDefault2">
                Belum Lunas
            </label>
        </div>

      
      </div>
    <div class="col">
      <button type="submit" class="btn btn-primary" id="simpan" name="simpan_booking">Simpan</button>
    </div>
</form>

<hr class="my-4">


<div class="row mt-3 justify-content-center" >
          <table class="table">
            <thead class="table-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Lapangan</th>
                <th scope="col">Waktu</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="booking-list">
              <?php
                $i = 1; 
                foreach ($booking as $row) : ?>
                <tr>
                  <th scope="row"><?=$i?></th>
                  <td><?=$row['nama']?></td>
                  <td><?=$row['lapangan']?></td>
                  <td><?=$row['waktu']?> jam</td>
                  <td>RP. <?=$row['total_harga']?></td>
                  <td>
                    <?php
                      if($row['status'] == "Lunas"){
                    ?>
                        <span class="badge text-bg-success"><?=$row['status']?></span>
                    <?php
                      }else{
                    ?>
                        <span class="badge text-bg-warning"><?=$row['status']?></span>
                    <?php
                      }
                    ?>
                  </td>
                  <td class="d-flex flex-row">
                    <a class="me-1" href="index.php?op=edit&id=<?=$row['id'];?>">
                        <button type="submit" class="btn btn-primary" name="edit" id="edit">Edit</button>
                    </a>
                    <a class="me-1" href="index.php?op=delete&id=<?=$row['id'];?>" onclick="return confirm('Yakin ingin mengapus data?')">
                        <button type="submit" class="btn btn-danger" name="hapus" id="hapus">Hapus</button>
                    </a>
                </td>
                </tr>
              <?php 
                  $i++;
                endforeach;  ?>
            </tbody>
          </table>
        </div>