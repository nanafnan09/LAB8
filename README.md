# LAB8

Nama : Afnan Dika Ramadhan

NIM : 312410518

Kelas : TI24.A5

MataKuliah : Pemrograman Web


# PRATIKUM 8

1.

![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/1.png)

Buat DB terlebih dahulu 'Latihan 1' setelah itu buka SQL dan masukan code ini kedalam SQL

2.

![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/2.png)

Selanjutnya klik 'data_barang' dan klik SQL masukan kode berikut

3.  

 ![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/3.png)

 Tampilan data base akan seperti ini

 4. 

 ![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/4.png)


 Masukan Kode ini untuk menambahkan foto pada data HP 

 ```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "latihan1";
$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn == false)
{
echo "Koneksi ke server berhasil.";
die();
} 
?>
```

Menggunakan ekstensi MySQLi untuk koneksi.

Detail koneksi:

$host: localhost

$user: root

$pass: "" (kosong)

$db: latihan1

Catatan: Anda harus membuat database dengan nama latihan1 di server MySQL Anda dan mengatur tabel data barang sesuai kebutuhan.

5.

```php
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
```

![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/5.png)

Tampilkan Data (READ - index.php)

Mengambil semua data dari tabel data_barang.

Menampilkan data dalam tabel yang rapi, termasuk Nama Barang, Kategori, Harga Jual, Harga Beli, Stok, dan Gambar barang.

Menggunakan fungsi number_format() untuk memformat tampilan harga jual dan beli menjadi format mata uang yang mudah dibaca (dengan pemisah ribuan).

Menyediakan tautan Ubah dan Hapus untuk setiap baris data.

6.

```php
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

if (isset($_POST['submit']))

    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar  = null;

    if ($file_gambar ['error'] == 0)
    {
        $filename  = str_replace(' ', '_', $file_gambar ['name']);      
        $destination = dirname(__FILE__) . '/image/'. $filename; 
        
        if(move_uploaded_file($file_gambar ['tmp_name'], $destination))
        {
            $gambar = 'gambar/' . $filename; 
    }

    $sql = 'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) ';
    $sql.= "VALUE ('{$nama}', '{$kategori}', '{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')";

    $result  = mysqli_query($conn, $sql);

    header('location: index.php');
}
?>
```

![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/6.png)

Tambah Data (CREATE - tambah.php)

Menerima input dari formulir (form) untuk data barang.

Memproses unggahan file gambar. Gambar akan disimpan di direktori image/.

Nama file gambar yang diunggah diubah dengan mengganti spasi ( ) menjadi garis bawah (_).

Menyimpan semua data, termasuk jalur gambar, ke dalam tabel data_barang.

Setelah berhasil, pengguna diarahkan kembali ke index.php.

7.

```php
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
```

![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/7.png)

Ubah Data (UPDATE - ubah.php)

Menampilkan Data Lama: Ketika diakses melalui URL ubah.php?id=..., script akan mengambil data barang berdasarkan id_barang dan menampilkannya di form (GET request).

Fungsi helper is_select() digunakan untuk menjaga opsi <select> Kategori tetap terpilih sesuai data lama.

Menyimpan Perubahan: Setelah formulir disubmit (POST request):

Data barang akan diperbarui menggunakan query UPDATE.

Jika ada file gambar baru yang diunggah, gambar lama akan diganti. Jika tidak ada gambar baru, jalur gambar lama akan dipertahankan.

Setelah berhasil, pengguna diarahkan kembali ke index.php.


8.

```php
<?php
include_once 'koneksi.php';
$id = $_GET['id'];
$sql = "DELETE FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);
header('location: index.php');
?>
```

![foto](https://github.com/nanafnan09/LAB8/blob/da50adc5dada334902e69bcd56b671bcc0327758/Lab%208%20Image/8.png)

Hapus Data (DELETE - hapus.php)

Menerima id barang melalui parameter URL ($_GET['id']).

Menghapus data barang yang sesuai dari tabel data_barang menggunakan query DELETE.

Pada index.php, fungsi onclick="return confirm(...) ditambahkan pada tautan hapus untuk memastikan pengguna benar-benar ingin menghapus data.

Setelah berhasil, pengguna diarahkan kembali ke index.php.

