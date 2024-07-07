<!-- loader.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /*background: #1d83c4;*/
            width: 100vw;
            height: 100vh;
            background: url("../assets/images/backsc.jpg") no-repeat center/cover;
            backdrop-filter: blur(0.5px);
            background-size: 100% 100%;
            overflow: hidden;
        }

        @media (max-width: 730px) {
            body {
                background-size: 1000px 110%;
            }
        }

        /* Style for the loader */
        .loading {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
            margin-left: -50px;
        }

        .dots-container {
            display: flex;
        }

        .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #3498db;
            margin: 0 5px;
            opacity: 0.3;   
        }
        #label,.dot{
            animation: animateDot 1.5s infinite;
        }
        #label{
            margin-top:-15px;
            font-weight:bolder;
            font-size:1.4rem;
            font-family: "Poppins", sans-serif;
        }

        @keyframes animateDot {

            0%,
            80%,
            100% {
                opacity: 0.5;
            }

            40% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="loading" id="loader">
        <img src="../assets/images/semcom-logo.png" alt="College Logo" class="logo">
        
            <div class="dots-container">
                <span id="label">Server is Offline</span>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
    </div>
</body>

</html>