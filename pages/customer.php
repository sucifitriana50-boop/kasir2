<?php
include(__DIR__ . '/../koneksi.php');

$aksi = $_GET['aksi'] ?? '';
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp   = $_POST['telp'];

    mysqli_query($conn, "INSERT INTO customer VALUES (NULL, '$nama', '$alamat', '$telp')");
    header("Location: dashboard.php?page=customer");
    exit;
}

if (isset($_POST['update'])) {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp   = $_POST['telp'];

    mysqli_query($conn, "UPDATE customer SET
        nama_customer='$nama',
        alamat='$alamat',
        telp='$telp'
        WHERE id_customer='$id'");

    header("Location: dashboard.php?page=customer");
    exit;
}

if ($aksi == 'hapus') {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM customer WHERE id_customer='$id'");
    header("Location: dashboard.php?page=customer");
    exit;
}

?>

<div class="container mt-4">

<?php if ($aksi == 'tambah') { ?>

<!-- FORM TAMBAH -->
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Customer</h5>
    </div>

    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Customer</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">No Telepon</label>
                <input type="text" name="telp" class="form-control" required>
            </div>

            <button type="submit" name="simpan" class="btn btn-success">
                💾 Simpan
            </button>
            <a href="dashboard.php?page=customer" class="btn btn-secondary">
                ↩ Kembali
            </a>
        </form>

        <?php } elseif ($aksi == 'edit') {
    $id = $_GET['id'];
    $edit = mysqli_query($conn, "SELECT * FROM customer WHERE id_customer='$id'");
    $row = mysqli_fetch_assoc($edit);
?>

<h4>Edit Customer</h4>

<form method="POST">
    <input type="hidden" name="id" value="<?= $row['id_customer']; ?>">

    <div class="mb-3">
        <label>Nama Customer</label>
        <input type="text" name="nama" class="form-control"
               value="<?= $row['nama_customer']; ?>" required>
    </div>

    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" required><?= $row['alamat']; ?></textarea>
    </div>

    <div class="mb-3">
        <label>No Telepon</label>
        <input type="text" name="telp" class="form-control"
               value="<?= $row['telp']; ?>" required>
    </div>

    <button name="update" class="btn btn-primary">Update</button>
    <a href="dashboard.php?page=customer" class="btn btn-secondary">Batal</a>
</form>

    </div>
</div>

<?php } else { ?>

<!-- TABEL CUSTOMER -->

<div class="d-flex justify-content-between mb-3">
    <h4>List Customer</h4>
    <a href="dashboard.php?page=customer&aksi=tambah" class="btn btn-success">
        + Tambah Customer
    </a>
</div>

<table class="table table-bordered">
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>No Telp</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>

<?php
$no = 1;
$data = mysqli_query($conn, "SELECT * FROM customer");
while ($row = mysqli_fetch_assoc($data)) {
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama_customer'] ?></td>
    <td><?= $row['alamat'] ?></td>
    <td><?= $row['telp'] ?></td>
    <td>
        <a href="dashboard.php?page=customer&aksi=edit&id=<?= $row['id_customer']; ?>"
           class="btn btn-sm btn-primary">Edit</a>

        <a href="dashboard.php?page=customer&aksi=hapus&id=<?= $row['id_customer']; ?>"
           class="btn btn-sm btn-danger"
           onclick="return confirm('Yakin hapus?')">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</tbody>
</table>

<?php } ?>

</div>
