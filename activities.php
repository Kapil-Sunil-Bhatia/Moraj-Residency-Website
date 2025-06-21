<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">

    <title>Activities</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Marcellus:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
</head>

<style>
* {
    margin: 0;
    padding: 0;
    outline: none;
    border: none;
    box-sizing: border-box;
    font-family: "Marcellus", sans-serif;

}

body {
    background-color: #FFEAEA;
}

*:before,
*:after {
    box-sizing: border-box;
}

html,
body {
    min-height: 100%;
}

body {
    background-color: #FFEAEA;
}

.topnav {
    background-color: #4C0033;
    overflow: hidden;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    height: 50px;
}

.topnav h3.logo {
    display: inline-block;
    margin-top: 0.5pc;
    margin-left: 1pc;
    color: #283142;
    font-weight: 500;
    font-size: 20px;
    color: white;
    margin-top: 12px;
    text-transform: uppercase;
    font-weight: bold;
}

.topnav a {
    float: right;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 20px;
    cursor: pointer;
    color: #283142;
    font-weight: 500;

}

.topnav a.active {
    background-color: #F5C6EC;
    color: #4C0033;
    cursor: pointer;
    margin-top: -4px;
    font-weight: bold;
}

.topnav a:hover {
    background-color: #4C0033;
    color: #F5C6EC;
    cursor: pointer;
}

h4 {
    display: table;
    margin: 5% auto 0;
    text-transform: uppercase;
    font-family: 'Anaheim', sans-serif;
    font-size: 2em;
    font-weight: 400;
}

.container {
    margin: 5% auto;
    width: 300px;
    height: 200px;
    position: relative;
    display: flex;
    flex-direction: row: align-items: center;
    justify-content: center;
    perspective: 450px;
}

button {
    border: none;
    cursor: pointer;
    color: white;
    background: none;
    transition: all .3s ease-in-out;
}

.activity-container {
    width: 100%;
    /* height: 100vh; */
    display: flex;
    justify-content: center;
    align-items: center;
}

.activity-carousel-view {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    /* padding: 44px 0; */
    transition: all 0.25s ease-in;
}

.activity-carousel-view .activity-item-list {
    max-width: 1000px;
    width: 100%;
    padding: 50px 10px;
    display: flex;
    gap: 48px;
    scroll-behavior: smooth;
    transition: all 0.25s ease-in;
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
    overflow: auto;
    scroll-snap-type: x mandatory;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.activity-item-list::-webkit-scrollbar {
    display: none;
}

.activity-prev-btn {
    background: none;
    cursor: pointer;
}

.activity-next-btn {
    cursor: pointer;
}

.activity-item-container {
    text-align: center;
}

.activity-item {
    scroll-snap-align: center;
    width: 1000px;
    height: 500px;
    background-color: black;
    border-radius: 8px;
}

h4 {
    display: table;
    margin: 5% auto 0;
    text-transform: uppercase;
    font-family: 'Anaheim', sans-serif;
    font-size: 2em;
    font-weight: 400;
}
</style>

<body>
    <div class="topnav">
        <h3 class="logo">Moraj Residency</h1>
            <a class="active" href="index.php" style="cursor: pointer;">Home</a>
            <!-- <a href="#">Register</a> -->
    </div>
    <h4 style="font-family: Marcellus, sans-serif; margin-top:100px; font-weight:bold; color:#4C0033!important;">Exploring
        the diverse range of club activities offered at Moraj</h4>
    <div class="activity-container">
        <div class="activity-carousel-view">
            <button id="activity-prev-btn" class="activity-prev-btn">
                <svg viewBox="0 0 512 512" width="20" title="chevron-circle-left">
                    <path
                        d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zM142.1 273l135.5 135.5c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L226.9 256l101.6-101.6c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L142.1 239c-9.4 9.4-9.4 24.6 0 34z" />
                </svg>
            </button>
            <div id="activity-item-list" class="activity-item-list">
                <?php if (isset($_GET['dance'])) { ?>
                    <div class="activity-item-container">
                    <img class="activity-item" src="/img/dance1.jpg" />
                    <p>Dance</p>
                </div>
                
                
                <div class="activity-item-container">
                    <img class="activity-item" src="/img/dance2.jpg" />
                    <p>Dance</p>
                </div> <?php }?>  <?php if (isset($_GET['yoga'])) { ?>
                <div class="activity-item-container">
                    <img class="activity-item" src="/img/yoga1.jpg" />
                    <p>Yoga</p>
                </div>
                <div class="activity-item-container">
                    <img class="activity-item" src="/img/yoga2.jpg" />
                    <p>Yoga</p>
                </div>
                <div class="activity-item-container">
                    <img class="activity-item" src="/img/yoga3.jpg" />
                    <p>Yoga</p>
                </div><?php }?>
               <!-- <div class="activity-item-container">
                    <img class="activity-item" src="" />
                    <p></p>
                </div> -->
                <!-- Add more images and descriptions -->
            </div>
            <button id="activity-next-btn" class="activity-next-btn">
                <svg viewBox="0 0 512 512" width="20" title="chevron-circle-right">
                    <path
                        d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z" />
                </svg>
            </button>
        </div>
    </div>

</body>
<script>
const prev = document.getElementById('activity-prev-btn')
const next = document.getElementById('activity-next-btn')
const list = document.getElementById('activity-item-list')

const itemWidth = 1000
const padding = 10

prev.addEventListener('click', () => {
    list.scrollLeft -= itemWidth + padding
})

next.addEventListener('click', () => {
    list.scrollLeft += itemWidth + padding
})

// Automatic carousel slide
let currentIndex = 0;
const slideInterval = 5000; // Change slide every 3 seconds

function nextSlide() {
    currentIndex = (currentIndex + 1) % list.children.length;
    list.scrollTo({
        left: currentIndex * (itemWidth + padding),
        behavior: 'smooth'
    });
}

// Start automatic slide
let slideTimer = setInterval(nextSlide, slideInterval);

// Pause automatic slide when mouse hovers over the carousel
list.addEventListener('mouseenter', () => {
    clearInterval(slideTimer);
});

// Resume automatic slide when mouse leaves the carousel
list.addEventListener('mouseleave', () => {
    slideTimer = setInterval(nextSlide, slideInterval);
});
</script>

</html>