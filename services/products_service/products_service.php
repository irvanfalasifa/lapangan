<?php

error_reporting(0);

$products = get_CURL('http://localhost/products-service/api_tampil_all.php');

$nama = "";
$no_wa = "";
$alamat = "";
$sukses = "";
$error = "";

if(isset($_GET['op'])){
  $op = $_GET['op'];
}else{
  $op = "";
}
  
if($op == 'delete'){
  $id = $_GET['id'];
  delete_CURL('http://localhost/products-service/api_hapus.php?id=' . $id);

  if($id){
    $sukses = "Berhasil hapus data";
  }else{
    $error = "Gagal hapus data";
  }
}

if($op == 'update'){
  $id = $_GET['id'];
  $product = get_CURL('http://localhost/products-service/api_tampil_byid.php?id=' . $id);
  $product = $product[0];
  $nama = $product['nama'];
  $harga = $product['harga'];
  $deskripsi = $product['deskripsi'];
  if($nama == ''){
    $error = "Data tidak ditemukan";
  }
}

if(isset($_POST['simpan_product'])){
  $post = [
    'nama' => $_POST['nama'],
    'harga' => $_POST['harga'],
    'deskripsi' => $_POST['deskripsi']
  ];

  $put = [
    'id' => $_GET['id'],
    'nama' => $_POST['nama'],
    'harga' => $_POST['harga'],
    'deskripsi' => $_POST['deskripsi']
  ];

  if($op == 'update'){
    if($put){
      put_CURL('http://localhost/products-service/api_edit.php', $put);
      $sukses = "Data berhasil diupdate";
    }else{
      $error = "Data gagal diupdate";
    }
  }else{
    if($post){
      $sukses = "Berhasil memasukan data baru";
      post_CURL('http://localhost/products-service/api_tambah.php', $post);
    }else{
      $error = "Gagal memasukan data";
    }
  }
}


?>

<h1 class="mb-5 d-inline-block">Data Product</h1>

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
        <input type="text" class="form-control" id="specificSizeInputName" value="<?php echo $nama;?>"  placeholder="Nama Lapangan" name="nama">
      </div>
      <div class="col">
          <input type="number" class="form-control" id="specificSizeInputNoWa" value="<?php echo $harga;?>" placeholder="Harga/Jam" name="harga">
      </div>
      <div class="col">
          <input type="text" class="form-control" id="specificSizeInputAddress" value="<?php echo $deskripsi;?>" placeholder="Deskripsi" name="deskripsi">
      </div>
    <div class="col">
      <button type="submit" class="btn btn-primary" id="simpan" name="simpan_product">Simpan</button>
    </div>
</form>

<hr class="my-4">

<div class="row mt-3 justify-content-center">
  <table class="table">
    <thead class="table-light">
      <tr class="">
        <th scope="col">No</th>
        <th scope="col">Nama Lapangan</th>
        <th scope="col">Harga</th>
        <th scope="col">Deskripsi</th>
        <th scope="col">aksi
        </th>
      </tr>
    </thead>
    <tbody>
      <?php
        $i = 1; 
        foreach ($products as $row) : ?>
          <tr>
            <th scope="row"><?= $i;?></th>
            <td><?=$row['nama'];?></td>
            <td><?=$row['harga'];?></td>
            <td><?=$row['deskripsi'];?></td>
            <td class="d-flex flex-row">
              <a class="me-1" href="index.php?op=update&id=<?=$row['id'];?>">
                <button type="submit" class="btn btn-primary" name="edit" id="edit">Edit</button>
              </a>
              <a href="index.php?op=delete&id=<?=$row['id'];?>" onclick="return confirm('Yakin ingin mengapus data?')">
                <button type="submit" class="btn btn-danger" name="hapus" id="hapus">Hapus</button>
              </a>
            </td>
          </tr>
      <?php 
          $i++;
        endforeach;
      ?>
    </tbody>
  </table>
</div>