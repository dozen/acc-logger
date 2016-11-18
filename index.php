<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>加速度センサーの値を取る</title>
    <style>
        @import url(http://fonts.googleapis.com/earlyaccess/notosansjapanese.css);

        html, body {
            font-size: 18px;
            font-family: 'Noto Sans Japanese', sans-serif;
            text-align: center;
            background-color: #fafafa;
        }
    </style>
</head>
<body>
<header>
    <h1>重力加速度を除いた加速度 加速度 回転速度</h1>
</header>
<main>
    <div>
        <div id="ctl">
            <select id="type" name="type">
                <option value="walk">walk</option>
                <option value="car">car</option>
                <option value="train">train</option>
            </select>
            <button id="start">Start</button>
        </div>
        <div>
            <p><span id="result"></span></p>
        </div>
        <div id="interval">
            <p><span id="i-msec"></span></p>
        </div>
        <div id="acceleration">
            <h2>acceleration[m/s^2]</h2>
            <p>x: <span id="acc-x"></span></p>
            <p>y: <span id="acc-y"></span></p>
            <p>z: <span id="acc-z"></span></p>
        </div>
        <div id="accelerationIncludingGravity">
            <h2>accelerationIncludingGravity[m/s^2]</h2>
            <p>x: <span id="acc-gx"></span></p>
            <p>y: <span id="acc-gy"></span></p>
            <p>z: <span id="acc-gz"></span></p>
        </div>
        <div id="rotationRate">
            <h2>rotationRate[degree/s]</h2>
            <p>a: <span id="rr-a"></span></p>
            <p>b: <span id="rr-b"></span></p>
            <p>g: <span id="rr-g"></span></p>
        </div>
    </div>
</main>

<script src="main.js"></script>
</body>
</html>