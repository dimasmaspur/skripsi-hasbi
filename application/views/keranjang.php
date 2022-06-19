<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Keranjang Pesanan</h1>
<!-- <a href="<?= base_url('android/confirm') ?>" class="btn btn-success"   type="button">
     <i class="fas fa-check"></i>
    Konfirmasi Pesananan
</a> -->

<button class="btn btn-success"   type="button" data-toggle="modal" data-target="#konfirmasi">
     <i class="fas fa-plus"></i>
Konfirmasi Pesanan
</button>
<br>
<br>
<h5>Total : Rp. <?=$datatotal;?></h5>
<br>
<!-- DataTales Example -->
<div class="card shadow mb-4 mt-2">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>QTY</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                    $no = 1;
                    foreach($datamenu as $data => $menu){
                ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $menu['namamenu'];?></td>
                        <td><?= $menu['harga'];?></td>
                        <td><?= $menu['qty'];?></td>
                        <td><?= $menu['subtotal'];?></td>
                        
                        <td>
                        <a href="<?= base_url('android/delete_cart/'.$menu['id']); ?>" class="btn btn-danger btn-circle">
                            <i class="fas fa-trash"></i>
                        </a>
                        </td>
                    </tr>
                <?php
                    
                $no++;
                }
                ?>

                
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Silahkan Masukan Alamat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" enctype="multipart/form-data" action="<?= base_url('android/confirm'); ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" id="" cols="30" rows="5" required></textarea>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Kota Pengiriman</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="kota" required>
                    <option selected>pilih...</option>
                    <option value="JABODETABEK">JABODETABEK</option>
                    <option value="Luar JABODETABEK">Luar JABODETABEK</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Notes</label>
                <textarea name="notes" class="form-control" id="" cols="30" rows="3" required></textarea>
            </div>
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
        </form>
      </div>
    </div>
  </div>
</div>

