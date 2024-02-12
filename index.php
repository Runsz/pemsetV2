<?php
    $db = mysqli_connect('localhost','root','','db_pemset');

    if (!$db) {
        echo 'Koneksi eror';
    }

    $query = 'SELECT * FROM peminjaman';
    $result = mysqli_query($db,$query);
    $peminjaman = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (isset($_POST['tambah'])) {
        $peminjam = $_POST['peminjam'];
        $aset = $_POST['aset'];
        $jml_aset = $_POST['jml_aset'];
        $tgl_pinjam = date('Y-m-d');
        $tgl_rencana_kembali = $_POST['tgl_kembali'];
        $peruntukkan = $_POST['peminjam'];
        $status = 1;

        $query = "INSERT INTO `peminjaman`(`peminjam`, `aset`, `jml_aset`, `tgl_pinjam`, `tgl_rencana_kembali`, `peruntukkan`, `status`) 
                    VALUES ('$peminjam','$aset',$jml_aset,'$tgl_pinjam','$tgl_rencana_kembali','$peruntukkan',$status)";
        $result = mysqli_query($db,$query);
        if ($result) {
            header('Location:index.php');
        }
    }

    if (isset($_POST['edit'])) {
        $id = (int)$_POST['id'];
        $status = (int)$_POST['sts'];

        if ($status == 3) {
            $today = date('Y-m-d');
            $query = "UPDATE peminjaman SET tgl_pengembalian='$today', status=$status  WHERE id=$id";
            $result = mysqli_query($db,$query);
            if ($result) {
                header('Location:index.php');
            }  
        }
        else {
            $query = "UPDATE peminjaman SET status=$status, tgl_pengembalian=NULL  WHERE id=$id";
            $result = mysqli_query($db,$query);
            if ($result) {
                header('Location:index.php');
            }   
        }
    }

    if (isset($_POST['urutkan'])) {
        $key = $_POST['sort'];
        
        function sorting(&$arr, $key){
            for ($i=0; $i < count($arr); $i++) { 
                $swap = false;
                for ($j=0; $j < count($arr) - $i - 1; $j++) { 
                    if ($arr[$j][$key] > $arr[$j+1][$key]) {
                        $sementara = $arr[$j];
                        $arr[$j] = $arr[$j+1];
                        $arr[$j+1] = $sementara;
                        $swap = true;
                    }
                }
                if ($swap == false) {
                    break;
                }
            }
        }

        sorting($peminjaman,$key);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemset</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <a href="index.php"><h1>PemSet</h1></a>
            <form action="index.php" method="post">
                <input placeholder=" Cari nama aset" name="keyword" type="text" required oninvalid="this.setCustomValidity('data tidak boleh kosong')">
                <button type="submit" name="cari" value="cari">Cari</button>
            </form>
        </header>
        <main>
            <div class="add">
                <?php
                    if (!isset($_GET['id'])) { ?>
                        <h2>Tambah Peminjaman</h2>
                        <form action="index.php" method="post">
                            <label for="">Nama Peminjam</label>
                            <input type="text" name="peminjam" required><br>
                            <label for="">Nama Aset</label>
                            <input type="text" name="aset" required><br>
                            <label for="">Jumlah Aset</label>
                            <input type="number" name="jml_aset" required><br>
                            <label for="">Tanggal Rencana Pengembalian</label>
                            <input class="tgl" type="date" name="tgl_kembali" required><br>
                            <label for="">Peruntukkan</label>
                            <input type="text" name="peruntukkan" required><br>
                            <button name="tambah" value="tambah" type="submit">Tambah</button>
                        </form>
                <?php } ?>
                <?php
                    if (isset($_GET['id'])) { 
                        $id = (int)$_GET['id'];
                        $query = "SELECT * FROM peminjaman where id=$id";
                        $result = mysqli_query($db,$query);
                        $data = mysqli_fetch_array($result);
                ?>
                        <a href="index.php"><button style="margin-top: 20px;">+Tambah Peminjaman</button></a>
                        <h2>Edit Status Peminjaman</h2>
                        <form action="index.php" method="post">
                            <input name="id" type="hidden" value="<?php echo $data['id'] ?>">
                            <label for="">Nama Peminjam</label>
                            <input value="<?php echo $data['peminjam'] ?>" type="text" name="peminjam" disabled><br>
                            <label for="">Nama Aset</label>
                            <input value="<?php echo $data['aset'] ?>" type="text" name="aset" disabled><br>
                            <label for="">Jumlah Aset</label>
                            <input value="<?php echo $data['jml_aset'] ?>" type="number" name="jml_aset" disabled><br>
                            <label for="">Peruntukkan</label>
                            <input value="<?php echo $data['peruntukkan'] ?>" type="text" name="peruntukkan" disabled><br>
                            <label for="">Status</label>
                            <select name="sts" id="">
                                <option value="1" <?php echo $data['status'] == 1 ? 'selected' : '' ?>>Sedang dipinjam</option>
                                <option value="2" <?php echo $data['status'] == 2 ? 'selected' : '' ?>>Terlambat dikembalikan</option>
                                <option value="3" <?php echo $data['status'] == 3 ? 'selected' : '' ?>>Sudah dikembalikan</option>
                            </select><br>
                            <button name="edit" value="edit" type="submit">Edit</button>
                        </form>
                <?php } ?>
            </div>
            <div class="table-data">
                <form action="index.php" method="post">
                    <p>Urutkan Berdasarkan</p>
                    <select name="sort" id="">
                        <option value="jml_aset">Jumlah</option>
                        <option value="status">Status</option>
                        <option value="tgl_pinjam">Tanggal</option>
                    </select>
                    <button name="urutkan" value="urutkan" type="submit">Urutkan</button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Peminjam</td>
                            <td>Aset</td>
                            <td>Jumlah</td>
                            <td>Tanggal Pinjam</td>
                            <td>Tanggal Rencana Pengembalian</td>
                            <td>Tanggal Pengembalian</td>
                            <td>Peruntukkan</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_POST['cari'])) {
                                $key = $_POST['keyword'];

                                function search($arr, $key){
                                    $new = [];
                                    for ($i=0; $i < count($arr); $i++) { 
                                        if (strtolower($arr[$i]['aset']) == strtolower($key)) {
                                            array_push($new, $arr[$i]);
                                        }
                                    }
                                    return $new;
                                }

                                $data = search($peminjaman, $key);

                                for ($i=0; $i < count($data); $i++) { ?>
                                    <tr>
                                        <td><?php echo $i+1 ?></td>
                                        <td><?php echo $data[$i]['peminjam'] ?></td>
                                        <td><?php echo $data[$i]['aset'] ?></td>
                                        <td><?php echo $data[$i]['jml_aset'] ?></td>
                                        <td><?php echo $data[$i]['tgl_pinjam'] ?></td>
                                        <td><?php echo $data[$i]['tgl_rencana_kembali'] ?></td>
                                        <td><?php echo $data[$i]['tgl_pengembalian'] ?></td>
                                        <td><?php echo $data[$i]['peruntukkan'] ?></td>
                                        <td>
                                            <?php if ($data[$i]['status']==1) {echo 'Sedang dipinjam';} 
                                                else if ($data[$i]['status']==2) {echo 'Terlambat Dikembalikan';} 
                                                else{echo 'Sudah Dikembalikan';}?>
                                        </td>
                                        <td><a href="index.php?id=<?php echo $peminjaman[$i]['id'] ?>"><button>Edit</button></a></td>
                                    </tr>
                        <?php   }
                            }
                            else{
                                for ($i=0; $i < count($peminjaman); $i++) { ?>
                                    <tr>
                                        <td><?php echo $i+1 ?></td>
                                        <td><?php echo $peminjaman[$i]['peminjam'] ?></td>
                                        <td><?php echo $peminjaman[$i]['aset'] ?></td>
                                        <td><?php echo $peminjaman[$i]['jml_aset'] ?></td>
                                        <td><?php echo $peminjaman[$i]['tgl_pinjam'] ?></td>
                                        <td><?php echo $peminjaman[$i]['tgl_rencana_kembali'] ?></td>
                                        <td><?php echo $peminjaman[$i]['tgl_pengembalian'] ?></td>
                                        <td><?php echo $peminjaman[$i]['peruntukkan'] ?></td>
                                        <td>
                                            <?php if ($peminjaman[$i]['status']==1) {echo 'Sedang dipinjam';} 
                                                else if ($peminjaman[$i]['status']==2) {echo 'Terlambat Dikembalikan';} 
                                                else{echo 'Sudah Dikembalikan';}?>
                                        </td>
                                        <td><a href="index.php?id=<?php echo $peminjaman[$i]['id'] ?>"><button>Edit</button></a></td>
                                    </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>