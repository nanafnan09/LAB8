<?php
error_reporting (E_ALL);
include_once 'koneksi.php';

// Logika untuk menyimpan perubahan (POST request)
if (isset($_POST['submit']))
{
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar  = null;

    if ($file_gambar ['error'] == 0)
    {
        $filename  = str_replace(' ', '_', $file_gambar['name']);
        $destination = dirname(__FILE__) . '/gambar/' . $filename;
        if (move_uploaded_file($file_gambar['tmp_name'], $destination))
        {
            $gambar = 'image/' . $filename;
        }
    }

    $sql = 'UPDATE data_barang SET ';
    // Perbaikan kutip dan koma: nama = '{$nama}', kategori = '{$kategori}'
    $sql.= "nama = '{$nama}', kategori = '{$kategori}', "; 
    $sql.= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', stok = '{$stok}' ";
    
    if (!empty($gambar))
        $sql.=", gambar = '{$gambar}' ";
    
    $sql.= "WHERE id_barang = '{$id}'";

    $result  = mysqli_query($conn, $sql);

    header('location: index.php');
}

// Logika untuk menampilkan data yang akan diubah (GET request)
$id = $_GET['id'];
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);

if (!$result) die('Error: Data tidak tersedia');

$data = mysqli_fetch_array($result);

// Fungsi helper untuk menentukan opsi <select> yang terpilih
function is_select($var, $val) {
    // Membandingkan data dari DB ($var) dengan nilai opsi ($val)
    if ($var == $val) return 'selected="selected"';
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubah Barang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { width: 60%; margin: 0 auto; }
        h1 { color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .main { padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .input { margin-bottom: 15px; }
        .input label { display: block; font-weight: bold; margin-bottom: 5px; }
        /* Style untuk menyesuaikan tampilan seperti pada Gambar 8.10 */
        .input label { width: 100px; display: inline-block; } 
        .input input[type="text"], .input select {
            width: 250px; /* Lebar input disesuaikan */
            padding: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit input[type="submit"] {
            background-color: #008CBA;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ubah Barang</h1>
        <div class="main">
            <form method="post" action="ubah.php"
                enctype="multipart/form-data">
                <div class="input">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" value="<?php echo $data['nama'];?>" />
                </div>
                <div class="input">
                    <label>Kategori</label>
                    <select name="kategori">
                        <option <?php echo is_select($data['kategori'], 'Komputer'); ?> value="Komputer">Komputer</option>
                        <option <?php echo is_select($data['kategori'], 'Elektronik');?> value="Elektronik">Elektronik</option>
                        <option <?php echo is_select($data['kategori'], 'Hand Phone'); ?> value="Hand Phone">Hand Phone</option>
                    </select>
                </div>
                <div class="input">
                    <label>Harga Jual</label>
                    <input type="text" name="harga_jual" value="<?php echo $data['harga_jual'];?>" />
                </div>
                <div class="input">
                    <label>Harga Beli</label>
                    <input type="text" name="harga_beli" value="<?php echo $data['harga_beli'];?>" />
                </div>
                <div class="input">
                    <label>Stok</label>
                    <input type="text" name="stok" value="<?php echo $data['stok'];?>" />
                </div>
                <div class="input">
                    <label>File Gambar</label>
                    <input type="file" name="file_gambar" />
                </div>
                <div class="submit">
                    <input type="hidden" name="id" value="<?php echo $data['id_barang'];?>" />
                    <input type="submit" name="submit" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
</body>
</html>