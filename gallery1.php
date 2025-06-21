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

div#carousel {
    perspective: 5000px;
    /* background: #100000; */
    padding-top: 10%;
    font-size: 0;
    margin-bottom: 3rem;
    overflow: hidden;
}

figure#spinner {
    transform-style: preserve-3d;
    height: 300px;
    transform-origin: 50% 50% -500px;
    transition: 1s;
}

figure#spinner img {
    width: 40%;
    max-width: 425px;
    position: absolute;
    left: 30%;
    transform-origin: 50% 50% -500px;
    outline: 1px solid transparent;
}

figure#spinner img:nth-child(1) {
    transform: rotateY(0deg);
}

figure#spinner img:nth-child(2) {
    transform: rotateY(-45deg);
}

figure#spinner img:nth-child(3) {
    transform: rotateY(-90deg);
}

figure#spinner img:nth-child(4) {
    transform: rotateY(-135deg);
}

figure#spinner img:nth-child(5) {
    transform: rotateY(-180deg);
}

figure#spinner img:nth-child(6) {
    transform: rotateY(-225deg);
}

figure#spinner img:nth-child(7) {
    transform: rotateY(-270deg);
}

figure#spinner img:nth-child(8) {
    transform: rotateY(-315deg);
}

div#carousel~span {
    color: #000;
    margin: 5%;
    display: inline-block;
    text-decoration: none;
    font-size: 2rem;
    transition: 0.6s color;
    position: relative;
    margin-top: -6rem;
    border-bottom: none;
    line-height: 0;
}

div#carousel~span:hover {
    color: #ffffff;
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
    <base href="/img/">
    <div id="carousel">
        <figure id="spinner">
            <img src="republic1.jpeg" alt>
            <img src="republic2.jpeg" alt>
            <img src="republic1.jpeg" alt>
            <img src="republic2.jpeg" alt>
            <img src="republic1.jpeg" alt>
            <img src="republic2.jpeg" alt>
            <img src="republic1.jpeg" alt>
            <img src="republic2.jpeg" alt>
        </figure>
    </div>
    <span style="float:left" class="ss-icon" onclick="galleryspin('-')">&lt;</span>
    <span style="float:right" class="ss-icon" onclick="galleryspin('')">&gt;</span>
</body>
<script>
var angle = 0;

function galleryspin(sign) {
    spinner = document.querySelector("#spinner");
    if (!sign) {
        angle = angle + 45;
    } else {
        angle = angle - 45;
    }
    spinner.setAttribute("style", "-webkit-transform: rotateY(" + angle + "deg); -moz-transform: rotateY(" + angle +
        "deg); transform: rotateY(" + angle + "deg);");
}
</script>

</html>