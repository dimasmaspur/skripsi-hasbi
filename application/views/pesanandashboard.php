<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pesanan Masuk</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4 mt-2">
    <div class="card-header py-3">
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Tanggal</th>
                        <th>Nama Pemesan</th>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                    $no = 1;
                    foreach($datauser as $data => $menu){
                ?>
                    <tr>
                        <td><?= $menu['id'];?></td>
                        <td><?= $menu['tanggal'];?></td>
                        <td><?= $menu['user'];?></td>
                        <td><?= $menu['nama'];?></td>
                        <td><?= $menu['qty'];?></td>
                        <td>Rp. <?= $menu['subtotal'];?></td>
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

