 <!-- Sidebar -->
 <?php
    $menu = array(
        "dashboard" => "fw-bold",
        "barangmasuk" => "fw-bold",
        "barangkeluar" => "fw-bold",
        "penempatan" => "fw-bold",
        "master" => "fw-bold",
    );

    $collapse = array(
        "master" => "",
    );

    $sub = array(
        "ruang" => "link-dark",
        "karyawan" => "link-dark",
        "pemasok" => "link-dark",
        "barang" => "link-dark",
        "anggaran" => "link-dark",
    );

    $page = (isset($_GET["page"])) ? $_GET["page"] : $page = "";

    switch ($page) {
        case "":
        case "dashboard":
        case "profil":
        case "ubahpassword":
            $menu["dashboard"] = "active";
            break;
        case "ruangdata":
        case "ruangtambah":
        case "ruangubah":
            $menu["master"] = "active";
            $collapse["master"] = "show";
            $sub["ruang"] = "link-success";
            break;
        case "karyawandata":
        case "karyawantambah":
        case "karyawanubah":
            $menu["master"] = "active";
            $collapse["master"] = "show";
            $sub["karyawan"] = "link-success";
            break;
        case "pemasokdata":
        case "pemasoktambah":
        case "pemasokubah":
            $menu["master"] = "active";
            $collapse["master"] = "show";
            $sub["pemasok"] = "link-success";
            break;
        case "barangdata":
        case "barangtambah":
        case "barangubah":
            $menu["master"] = "active";
            $collapse["master"] = "show";
            $sub["barang"] = "link-success";
            break;
        case "barangmasukdata":
        case "barangmasuktambah":
        case "barangmasukubah":
        case "barangmasukdetail":
            $menu["barangmasuk"] = "active";
            break;
        case "barangkeluardata":
        case "barangkeluartambah":
        case "barangkeluarubah":
        case "barangkeluardetail":
            $menu["barangkeluar"] = "active";
            break;
        case "penempatandata":
        case "penempatandetail":
            $menu["penempatan"] = "active";
            break;
        case "anggarandata":
        case "anggarantambah":
        case "anggaranubah":
        case "anggaranhapus":
            $menu["master"] = "active";
            $collapse["master"] = "show";
            $sub["anggaran"] = "link-success";
            break;
        default:
            include "pages/404.php";
    }

    ?>
 <div class="bg-white" id="sidebar-wrapper" style="width: 300px;">
     <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
         <img src="assets/images/remove-logo.png" alt="" width="25%" style="margin-left: -15px;">S I B A G U S
     </div>
     <div class="list-group list-group-flush my-3">
         <a href="index.php" class="list-group-item list-group-item-action bg-transparent abu-text  <?= $menu["dashboard"] ?>"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
         <button class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["master"] ?>" data-bs-toggle="collapse" data-bs-target="#master-collapse" aria-expanded="true">
             <i class="fas fa-list me-2"></i>Master
         </button>
         <div class="collapse  <?= $collapse["master"] ?>" id="master-collapse">
             <ul class="btn-toggle-nav list-unstyled ps-4">
                 <li><a href="?page=ruangdata" class="<?= $sub["ruang"] ?> rounded">Ruang</a></li>
                 <?php
                    if ($_SESSION["level"] == "admin") {
                    ?>
                     <li><a href="?page=karyawandata" class="<?= $sub["karyawan"] ?> rounded">Karyawan</a></li>
                 <?php
                    }
                    ?>
                 <li><a href="?page=pemasokdata" class="<?= $sub["pemasok"] ?> rounded">Pemasok</a></li>
                 <li><a href="?page=barangdata" class="<?= $sub["barang"] ?> rounded">Barang</a></li>
                 <li><a href="?page=anggarandata" class="<?= $sub["anggaran"] ?> rounded">Anggaran</a></li>
             </ul>
         </div>
         <a href="?page=barangmasukdata" class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["barangmasuk"] ?>"><i class="fas fa-boxes me-2"></i>Barang Masuk</a>
         <a href="?page=barangkeluardata" class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["barangkeluar"] ?>"><i class="fa-brands fa-dropbox"></i> Barang Keluar</a>
         <a href="?page=penempatandata" class="list-group-item list-group-item-action bg-transparent abu-text <?= $menu["penempatan"] ?>"><i class="fas fa-building me-2"></i>Penempatan</a>
         <form action="" method="post">
             <button name="logout_button" type="submit" onclick="javascript: return confirm('Yakin keluar?');" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
                 <i class="fas fa-power-off me-2"></i>Logout
             </button>
         </form>
     </div>
 </div>
 <!-- /#sidebar-wrapper -->