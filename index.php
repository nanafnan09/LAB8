<?php
include("koneksi.php"); 
$sql  = 'SELECT * FROM data_barang';
$result  = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 90%; margin: 0 auto; }
        h1 { color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .main table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .main th, .main td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .main th { background-color: #f2f2f2; color: #555; }
        .main td img { 
            width: 80px; 
            height: auto; 
            max-height: 80px;
            display: block; 
            object-fit: contain;
        } 
        .aksi a { margin-right: 10px; text-decoration: none; color: blue; }
        .aksi a:hover { text-decoration: underline; }
        .tambah-link { 
            display: inline-block; 
            margin: 10px 0; 
            padding: 8px 15px;
            background-color: #4CAF50; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px;
            font-weight: bold;
        }
        .tambah-link:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Barang</h1>
        <a href="tambah.php" class="tambah-link">Tambah Barang</a>
        <div class="main">
            <table>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Katagori</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
                
                <?php if($result): ?>
                <?php while($row = mysqli_fetch_array($result)): ?>
                <tr>
                    <td>
                        <img src="<?= $row['gambar'];?>" alt="<?= $row['nama'];?>">
                    </td>
                    <td><?= $row['nama'];?></td>
                    <td><?= $row['kategori'];?></td>
                    
                    <td><?= number_format($row['harga_jual'], 0, ',', '.');?></td>
                    <td><?= number_format($row['harga_beli'], 0, ',', '.');?></td> 
                    
                    <td><?= $row['stok'];?></td>
                    
                    <td class="aksi">
                        <a href="ubah.php?id=<?= $row['id_barang'];?>">Ubah</a> 
                        <a href="hapus.php?id=<?= $row['id_barang'];?>" onclick="return confirm('Yakin akan menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="7">Belum ada data</td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>