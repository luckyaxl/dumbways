<?php
$databaseHost = 'localhost';
$databaseName = 'testcrud';
$databaseUsername = 'root';
$databasePassword = 'zer0cod3';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (isset($_POST['submit'])) {
  if ($_POST['id']) {
    $removeid = $_POST['id'];
    $result = mysqli_query($mysqli, "DELETE FROM provinsi_tb WHERE id=" . $removeid);
  }

  if ($_POST['provinsi']) {
    $nama = $_POST['provinsi'];
    $diresmikan = $_POST['diresmikan'];
    $photo = $_POST['photo'];
    $pulau = $_POST['pulau'];

    $result = mysqli_query($mysqli, "INSERT INTO provinsi_tb(nama,diresmikan,photo,pulau) VALUES('$nama','$diresmikan','$photo','$pulau')");
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
  }

  if ($_POST['kabupaten']) {
    $nama = $_POST['kabupaten'];
    $provid = $_POST['provinsi_id'];
    $diresmikan = $_POST['diresmikan'];
    $photo = $_POST['photo'];

    $result = mysqli_query($mysqli, "INSERT INTO kabupaten_tb(nama,,provinsi_id,diresmikan,photo) VALUES('$nama','$provid','$diresmikan','$photo')");
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
  }
}
?>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Provinsi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://designrevision.com/demo/shards/extra/css/shards.min.css">
  <link rel="stylesheet" href="https://designrevision.com/demo/shards/extra/css/shards-extras.min.css">
</head>

<body>
  <div class="container py-5">
    <?php
    if (isset($_GET['detail'])) {
      $result = mysqli_query($mysqli, "SELECT * from provinsi_tb WHERE id={$_GET['detail']}");
      while ($provinsi = mysqli_fetch_array($result)) {
    ?>

        <!-- DETAIL SECTION  -->

        <div class="blog section text-center mb-5">
          <h3>Detail Provinsi <?php echo $provinsi['nama']; ?></h3>
        </div>

        <div class="col-lg-3 col-sm-6 px-2">
          <div class="card mb-3">
            <div class="p-3">
              <form action="" method="post">
                <input name="id" type="hidden" value="<?php echo $provinsi['id'] ?>" />
                <button type="submit" name="submit" class="btn btn-danger btn-sm btn-pill float-right font-weight-bold">Delete</button>
              </form>
            </div>
            <div class="card-body">
              <div class="text-center mb-3">
                <img class="img-fluid" style="width: 100px;" src="<?php echo $provinsi['photo'] ?>" />
              </div>
              <p class="font-weight-bold mb-0"><?php echo $provinsi['nama']; ?></p>
              <small>Diresmikan pada tanggal: <br /><span class="font-weight-bold"><?php echo $provinsi['diresmikan']; ?></span></small>
              <br />
              <small>Berada di Pulau <span class="font-weight-bold"><?php echo $provinsi['pulau'] ?></span></small>
            </div>
          </div>
        </div>

        <!-- END OF DETAIL SECTION  -->

      <?php
      }
    } else {
      $result = mysqli_query($mysqli, "SELECT * FROM provinsi_tb");
      ?>

      <!-- INDEX SESSION -->
      <div class="blog section text-center mb-5">
        <h3>Provinsi dan Kabupaten</h3>
      </div>
      <div class="d-flex justify-content-between mb-5">
        <form method="post" id="tableForm" action="/getJson">
          <div class="form-group">
            <select class="form-control" name="query">
              <option name="prov" value="1" selected>Provinsi</option>
              <option name="provkab" value="2">Provinsi & Kabupaten</option>
              <option name="pulau" value="3">Pulau</option>
            </select>
          </div>
        </form>
        <div>
          <button class="btn btn-primary btn-sm btn-pill mr-2 font-weight-bold" data-toggle="modal" data-target="#addprov">Add
            Provinsi</button>
          <button class="btn btn-primary btn-sm btn-pill font-weight-bold" data-toggle="modal" data-target="#addkab">Add
            Kabupaten</button>
        </div>
      </div>
      <div class="row">
        <?php
        while ($provinsi = mysqli_fetch_array($result)) {
        ?>
          <div class="col-lg-3 col-sm-6 px-2">
            <div class="card mb-3">
              <div class="card-body text-center p-2">
                <img class="img-fluid my-3" style="width: 100px;height: 100px" src="<?php echo $provinsi['photo'] ?>" />
                <p class="font-weight-bold mb-0"><?php echo $provinsi['nama']; ?></p>
                <small><?php echo $provinsi['diresmikan']; ?></small>
                <div class="p-3">
                  <a href="<?php echo $_SERVER['REQUEST_URI']; ?>?detail=<?php echo $provinsi['id'] ?>" class="btn btn-pill btn-block btn-sm btn-primary font-weight-bold">Detail</a>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
      <!-- END OF INDEX SESSION -->

    <?php
    }
    ?>
  </div>

  <form action="" method="post">
    <div class="modal fade" id="addprov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="provinsi" class="form-control" placeholder="Nama Provinsi" required>
            </div>

            <div class="form-group">
              <input type="text" name="diresmikan" class="form-control" placeholder="Tanggal Diresmikan" required>
            </div>

            <div class="form-group">
              <input type="text" name="photo" class="form-control" placeholder="url gambar" required>
            </div>

            <div class="form-group">
              <input type="text" name="pulau" class="form-control" placeholder="Nama Pulau" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <form action="" method="post">
    <div class="modal fade" id="addkab" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" name="kabupaten" class="form-control" placeholder="Nama Kabupaten" required>
            </div>

            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM provinsi_tb");
            ?>
            <div class="form-group">
              <select class="form-control" name="query">
                <option value="" selected>Pilih Provinsi</option>
                <?php
                while ($provinsi = mysqli_fetch_array($result)) {
                ?>
                  <option name="provinsi_id" value="<?php echo $provinsi['nama'] ?>"><?php echo $provinsi['nama'] ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <?
            ?>

            <div class="form-group">
              <input type="text" name="diresmikan" class="form-control" placeholder="Tanggal Diresmikan" required>
            </div>

            <div class="form-group">
              <input type="text" name="photo" class="form-control" placeholder="url gambar" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>