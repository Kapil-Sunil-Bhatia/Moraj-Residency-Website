<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">

    <title>Gallery</title>
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

#carousel {
    width: 100%;
    height: 100%;
    position: absolute;
    transform-style: preserve-3d;
    animation: rotation 90s infinite linear;
}

#carousel:hover {
    animation-play-state: paused;
}

#carousel figure {
    display: block;
    position: absolute;
    width: 210px;
    height: 116px;
    left: 10px;
    top: 100px;
    background: black;
    overflow: hidden;
    border: solid 2px black;
}

#carousel figure:nth-child(1) {
    transform: rotateY(0deg) translateZ(288px);
}

#carousel figure:nth-child(2) {
    transform: rotateY(40deg) translateZ(288px);
}

#carousel figure:nth-child(3) {
    transform: rotateY(80deg) translateZ(288px);
}

#carousel figure:nth-child(4) {
    transform: rotateY(120deg) translateZ(288px);
}

#carousel figure:nth-child(5) {
    transform: rotateY(160deg) translateZ(288px);
}

#carousel figure:nth-child(6) {
    transform: rotateY(200deg) translateZ(288px);
}

#carousel figure:nth-child(7) {
    transform: rotateY(240deg) translateZ(288px);
}

#carousel figure:nth-child(8) {
    transform: rotateY(280deg) translateZ(288px);
}

#carousel figure:nth-child(9) {
    transform: rotateY(320deg) translateZ(288px);
}

img {
    cursor: pointer;
    transition: all .5s ease;
    width: 100%;
    height: 100%;
}

img:hover {
    /* -webkit-filter: grayscale(0); */
    transform: scale(1.2, 1.2);
}

@keyframes rotation {
    from {
        transform: rotateY(0deg);
    }

    to {
        transform: rotateY(360deg);
    }
}
</style>

<body>
    <div class="topnav">
        <h3 class="logo">Moraj Residency</h1>
            <a class="active" href="index.php" style="cursor: pointer;">Home</a>
            <!-- <a href="#">Register</a> -->
    </div>
    <h4 style="font-family: Marcellus, sans-serif; margin-top:100px; font-weight:bold; color:#4C0033!important;">
        Moraj: Where
        cherished
        memories
        bloom in fleeting
        glimpses of beauty
    </h4>
    <center>
        <div class="container">
            <div id="carousel">
                <figure><img src="img/republic1.jpeg" alt=""></figure>
                <figure><img src="img/republic2.jpeg" alt=""></figure>
                <figure><img src="#" alt=""></figure>
                <figure><img src="#" alt=""></figure>
                <figure><img src="#" alt=""></figure>
                <figure><img src="#" alt=""></figure>
                <figure><img src="#" alt=""></figure>
                <figure><img src="#" alt=""></figure>
                <figure><img src="#" alt=""></figure>
            </div>
        </div>
    </center>
</body>
<script>
const prev = document.getElementById('prev-btn')
const next = document.getElementById('next-btn')
const list = document.getElementById('item-list')

const itemWidth = 150
const padding = 10

prev.addEventListener('click', () => {
    list.scrollLeft -= itemWidth + padding
})

next.addEventListener('click', () => {
    list.scrollLeft += itemWidth + padding
})
</script>

</html>