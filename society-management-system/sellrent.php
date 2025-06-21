<?php
// Include configuration file
require_once 'config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields are set
    if (isset($_POST['flat_number'], $_POST['name'], $_POST['flat_type'], $_POST['contact_number'], $_POST['sellrent'])) {
        // Store form data in the flat_listings table
        $stmt = $pdo->prepare("INSERT INTO flat_listings (flat_number, name, flat_type, contact_number) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['flat_number'], $_POST['name'], $_POST['sellrent']. "ing ". $_POST['flat_type'] , $_POST['contact_number']]);
        $flat_id = $pdo->lastInsertId(); // Get the ID of the inserted flat listing

        // Handle multiple file uploads
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["images"]["name"][$key]);
            move_uploaded_file($tmp_name, $target_file);

            // Store image paths in the flat_images table
            $stmt = $pdo->prepare("INSERT INTO flat_images (flat_id, image_path) VALUES (?, ?)");
            $stmt->execute([$flat_id, $target_file]);
        }
    }
}

// Include header
include 'header.php';
?>
<style>
    #formupload{
        background-color: #fff9e8;
    padding: 1rem;
    border: 1px black solid;
    }
    .btn{
        background: #430A5D;
        border: #430A5D;
    }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Flat Listings</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item active">Flat Listings</li>
    </ol>

    <!-- Upload form -->
    <div class="container">
        
        <h2>Upload Flat Details and Images</h2>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data" id="formupload">
            <div class="mb-3">
                <label for="flat_number" class="form-label">Flat Number</label>
                <input type="text" class="form-control" id="flat_number" name="flat_number" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label">Choose:-</label>
                <select name='sellrent'>
                    <option value='Sell'>Sell</option>
                    <option value='Rent'>Rent</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="flat_type" class="form-label">Description/Flat Type</label>
                <input type="text" class="form-control" id="flat_type" name="flat_type" required>
            </div>
            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" required>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Upload Images</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
<br>
    <!-- Display flat listings -->
    <div class="container">
        <h2>Flat Listings</h2>
        <div class="row">
            <?php
            // Fetch flat listings and associated images from the database
            $stmt = $pdo->query("SELECT * FROM flat_listings");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div id="carouselExampleControls<?= $row['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                                // Fetch images associated with the flat listing
                                $stmt_images = $pdo->prepare("SELECT * FROM flat_images WHERE flat_id = ?");
                                $stmt_images->execute([$row['id']]);
                                $first_image = true;
                                while ($image_row = $stmt_images->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                            <div class="carousel-item <?= $first_image ? 'active' : '' ?>">
                                <img src="<?= $image_row['image_path'] ?>" class="d-block w-100" alt="Flat Image">
                            </div>
                            <?php
                                    $first_image = false;
                                }
                                ?>
                        </div>
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#carouselExampleControls<?= $row['id'] ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleControls<?= $row['id'] ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['name'] ?></h5>
                        <p class="card-text">Flat Number: <?= $row['flat_number'] ?></p>
                        <p class="card-text">Description/Flat Type: <?= $row['flat_type'] ?></p>
                        <p class="card-text">Contact Number: <?= $row['contact_number'] ?></p>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
// Include footer
include 'footer.php';
?>