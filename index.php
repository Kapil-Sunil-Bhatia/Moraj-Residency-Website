<?php

require_once 'society-management-system/config.php';

$errorMessage = '';

if (isset($_POST['submit_btn'])) {
  // Retrieve form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Validate form data (you can add more validation as needed)
  if (empty($name) || empty($email) || empty($message)) {
      // Handle empty fields
      $error = "Please fill all fields.";
  } else {
      // Prepare and execute SQL query to insert data into the database
      $sql = "INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)";
      $stmt = $pdo->prepare($sql);
      if ($stmt->execute([$name, $email, $message])) {
          // Data inserted successfully
          $success = "Your message has been sent successfully.";
          // You can redirect the user to a thank you page or display a success message here
      } else {
          // Error inserting data
          $error = "Error: Unable to send message. Please try again later.";
      }
  }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Moraj Residency</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<body>

    <nav class="navbar">
        <div class="navbar-container container">
            <input type="checkbox" name="" id="">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
            <h1 class="logo">
                <?php
        $sql = "SELECT society_name FROM society";
        $stmt = $pdo->query($sql);
        
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $society_name = $row["society_name"];
                echo "$society_name";
            }
        } else {
            echo "No data available!!!!!!!!";
        }
        ?>
            </h1>
            <ul class="menu-items">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <!-- <li><a href="#food">Category</a></li> -->
                <li>
                    <div class="dropdown">
                        <a class="dropbtn">Committee</a>
                        <div class="dropdown-content">
                            <a href="#food-menu">Management Committee</a>
                            <a href="#testimonials">Members</a>
                        </div>
                </li>
                <li><a href="#activities">Activities</a></li>
                <li><a href="login.php">Login for Bill Payment</a></li>
                <li><a href="#contact">Contact Us</a></li>

                <!-- <li><a href="#food">Register</a></li> -->
        </div>
        <!-- <li><a href="#food-menu">Management Committee</a></li>
              <li><a href="#testimonials">Members</a></li> -->
        <!-- <li><a href="#contact">Contact</a></li> -->
        </ul>
        <!-- <h1 class="logo">Moraj Residency</h1> -->
        </div>
    </nav>

    <section class="showcase-area" id="showcase">
    <marquee><b>New Announcement!! Please check Login.<b></marquee>

        <div class="showcase-container" id="home">
            <div class="details">
            <h1 class="moraj" style=" float:left; font-size:7rem;">MORAJ </h1><br>
            <h1 class="residency" style="font-size:4rem; float:right">Residency </h1>
            <br><br><br><br>
                <h3 style="  color: #fffbb6;font-weight: 300; font-size: 25px; font-weight:bold">Kasturi Co-operative Society, Sanpada, Navi Mumbai</h3>
               
                <!-- <h3 style=" color: #fffbb6; font-weight: 300; font-size: 25px; font-weight:bold"></h3> -->
            </div>

            <!-- <img src="morajnew.png" style="padding: 5rem;" width="50%" height="100%"> -->
        </div>

    </section>

    <section id="about">
        <div class="about-wrapper container">
            <div class="about-text">
                <?php
        $sql = "SELECT society_name FROM society";
        $stmt = $pdo->query($sql);
        
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $society_name = $row["society_name"];
                echo "<h2>About $society_name</h2><br>";
            }
        } else {
            echo "No data available!!!!!!!!";
        }
        ?>
                <!-- <p class="small">About Us</p> -->
                <!-- <h2>About Moraj Residency</h2> -->
                <p>

                    <?php
// SQL query to retrieve all announcements, ordered by timestamp (latest first)
$sql = "SELECT id, about_text, about_status, timestamp FROM about ORDER BY timestamp DESC";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $about_id = $row["id"];
        $about = $row["about_text"];
        $about_status = $row["about_status"];
        $timestamp = $row["timestamp"];
        echo "<p>$about</p>";
    }
} else {
    echo "No data available!!!!!!!!";
}
?>

                </p>
            </div>
            <div class="about-img">
                <img src="img/building.jpg" alt="moraj_residency" />
            </div>
        </div>
    </section>
    <section id="food-menu">
        <!-- caraousel -->
        <h2 class="food-menu-heading" style="color:#4C0033; font-weight:bold">Management Committee (व्यवस्थापन समिती)
        </h2>

        <div class="container">
            <div class="carousel-view">
                <button id="prev-btn" class="prev-btn">
                    <svg viewBox="0 0 512 512" width="20" title="chevron-circle-left">
                        <path
                            d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zM142.1 273l135.5 135.5c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L226.9 256l101.6-101.6c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L142.1 239c-9.4 9.4-9.4 24.6 0 34z" />
                    </svg>
                </button>
                <div id="item-list" class="item-list">
                    <div class="item-container">
                        <img class="item"
                            src="img/vilasghone.jpg" />
                        <p class="textname">श्री विलास घोणे</p>
                        <p class="textname"><b>अध्यक्ष</b></p>

                    </div>
                    <div class="item-container">
                        <img class="item" src="img/prashant_mokashi.png" />
                        <p class="textname">श्री प्रशांत मोकाशी</p>
                        <p class="textname"><b>उपाध्यक्ष</b></p>
                    </div>
                    <div class="item-container">
                        <img class="item" src="img/dhanjay_Deshmukh.png" />
                        <p class="textname">अँड धनंजय देशमुख</p>
                        <p class="textname"><b>उपाध्यक्ष</b></p>
                    </div>
                    <div class="item-container">
                        <img class="item" src="img/rahul_patil.png" />
                        <p class="textname">श्री राहुल पाटील</p>
                        <p class="textname"><b>सचिव</b></p>
                    </div>
                    <div class="item-container">
                        <img class="item" src="img/devendra_khade.png" />
                        <p class="textname">श्री देवेंद्र खाडे</p>
                        <p class="textname"><b>सहसचिव</b></p>
                    </div>
                    <div class="item-container">
                        <img class="item" src="img/shashi_bhushan.png" />
                        <p class="textname">श्री शशी भूषण</p>
                        <p class="textname"><b>सहसचिव</b></p>
                    </div>
                    <div class="item-container">
                        <img class="item"
                            src="img/sunilshetty.jpg" />
                        <p class="textname">श्री सुनील शेट्टी</p>
                        <p class="textname"><b>खजिनदार</b></p>
                    </div>
                    <div class="item-container">
                        <img class="item"
                            src="img/sachinkesarkar.jpg" />
                        <p class="textname">श्री सचिन केसरकर</p>
                        <p class="textname"><b>सहखजिनदार</b></p>
                    </div>
                    <!-- Add more images and descriptions -->
                </div>
                <button id="next-btn" class="next-btn">
                    <svg viewBox="0 0 512 512" width="20" title="chevron-circle-right">
                        <path
                            d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z" />
                    </svg>
                </button>
            </div>
        </div>
    </section>


    <section id="testimonials">
        <center>
            <h2 class="testimonial-title" style="color:#4C0033; font-weight:bold">Members (सदस्य)</h2>


            <div class="container">
                <div class="carousel-view">
                    <button id="prev-btn1" class="prev-btn1">
                        <svg viewBox="0 0 512 512" width="20" title="chevron-circle-left">
                            <path
                                d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zM142.1 273l135.5 135.5c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L226.9 256l101.6-101.6c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L142.1 239c-9.4 9.4-9.4 24.6 0 34z" />
                        </svg>
                    </button>
                    <div id="item-list1" class="item-list1">
                        <div class="item-container">
                            <img class="item"
                                src="img/vandanahirwale.jpg" />
                            <p class="textname">श्रीमती वंदना हिरवाळे</p>
                        </div>
                        <div class="item-container">
                            <img class="item" src="img/namrata_ansari.png" />
                            <p class="textname">सौ. नम्रता अन्सारी</p>
                        </div>
                        <div class="item-container">
                            <img class="item" src="img/govind_mohite.png" />
                            <p class="textname">श्री गोविंद मोहिते</p>
                        </div>
                        <div class="item-container">
                            <img class="item"
                                src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" />
                            <p class="textname">श्री श्रीकृष्ण गायकवाड</p>
                        </div>
                        
                        <div class="item-container">
                            <img class="item" src="img/navneet_sharma.png" />
                            <p class="textname">श्री नवनीत शर्मा</p>
                        </div>
                        <div class="item-container">
                            <img class="item"
                                src="img/devramthalkar.jpg" />
                            <p class="textname">श्री देवराम थाळकर</p>
                        </div>
                        <div class="item-container">
                            <img class="item"
                                src="img/premanandshanbag.jpg" />
                            <p class="textname">श्री प्रेमानंद शानभाग</p>
                        </div>
                        <div class="item-container">
                            <img class="item"
                                src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" />
                            <p class="textname">श्री धर्मवीर सिंह</p>
                        </div>
                        <!-- Add more images and descriptions -->
                    </div>
                    <button id="next-btn1" class="next-btn1">
                        <svg viewBox="0 0 512 512" width="20" title="chevron-circle-right">
                            <path
                                d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z" />
                        </svg>
                    </button>
                </div>
            </div>
        </center>
    </section>
    <!-- activities -->

    <section id="activities">
        <center>
            <h2 class="testimonial-title" style="color:#4C0033; font-weight:bold">Club House Activities and Gallery</h2>
            <br>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="img/yoga.jpg" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">YOGA CLASS</h5>
                            <a href="activities.php?yoga" class="btn btn-primary"
                                style="background-color: #4C0033; border:none;">View
                                Photos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="row g-0">

                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">DANCE CLASS</h5>
                            <a href="activities.php?dance" class="btn btn-primary"
                                style="background-color: #4C0033; border:none;">View
                                Photos</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="img/dance.jpg" class="img-fluid1 rounded-end">
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="img/chess.jpg" class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">CHESS CLASS</h5>
                            <a href="activities.php" class="btn btn-primary"
                                style="background-color: #4C0033; border:none;">View
                                Photos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="row g-0">

                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">GALLERY</h5>
                            <a href="gallery.php" class="btn btn-primary"
                                style="background-color: #4C0033; border:none;">View
                                Photos</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="img/Gallery.jpg" class="img-fluid1 rounded-end">
                    </div>
                </div>
            </div>
            <!--<div class="card mb-3">-->
            <!--    <div class="row g-0">-->
            <!--        <div class="col-md-4">-->
            <!--            <img src="img/Gallery.jpg" class="img-fluid2 rounded-start">-->
            <!--        </div>-->
            <!--        <div class="col-md-8">-->
            <!--            <div class="card-body">-->
            <!--                <h5 class="card-title">GALLERY</h5>-->
            <!--                <a href="gallery.php" class="btn btn-primary"-->
            <!--                    style="background-color: #4C0033; border:none;">View Photos</a>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </center>
    </section>

    <!-- end -->


    <section id="contact">
        <div class="contact-container container">
            <div class="contact-img">
                <img src="img/contactus_vector.jpg" style="width: 80%; height: 100%;" alt="" />
            </div>

            <form class="form-container" method="post">
                <h2>Contact Us</h2>
                <h5>+91 81690 57578</h5>
                <input type="text" id="name" name="name" placeholder="Your Name" required />
                <input type="email" id="email" name="email" placeholder="E-Mail" required />
                <textarea type="message" id="message" name="message" cols="30" rows="2" maxlength="10000"
                    placeholder="Type Your Message" required></textarea>
                <button type="submit" name="submit_btn" class="submit_btn">Submit</button>

                <?php if (isset($error)) : ?>
                <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if (isset($success)) : ?>
                <p style="color: green;"><?php echo $success; ?></p>
                <?php endif; ?>

            </form>
        </div>
    </section>
    <!-- <footer id="footer">
        <h4>Copyright &copy; All Rights Reserved</h4>
    </footer> -->


</body>
<!-- 
    .................../ JS Code for smooth scrolling /...................... -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
$(document).ready(function() {
    // Add smooth scrolling to all links
    $("a").on("click", function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $("html, body").animate({
                    scrollTop: $(hash).offset().top,
                },
                800,
                function() {
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                }
            );
        } // End if
    });
});

const prev = document.getElementById('prev-btn')
const next = document.getElementById('next-btn')
const list = document.getElementById('item-list')
const prev1 = document.getElementById('prev-btn1')
const next1 = document.getElementById('next-btn1')
const list1 = document.getElementById('item-list1')

const itemWidth = 150
const padding = 10

prev.addEventListener('click', () => {
    list.scrollLeft -= itemWidth + padding
})

next.addEventListener('click', () => {
    list.scrollLeft += itemWidth + padding
})

prev1.addEventListener('click', () => {
    list1.scrollLeft -= itemWidth + padding
})

next1.addEventListener('click', () => {
    list1.scrollLeft += itemWidth + padding
})
</script>

</html>