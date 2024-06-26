<!-- loader.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <style>
        /* Style for the loader */
        .loading {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        .dots-container {
            display: flex;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #3498db;
            margin: 0 5px;
            opacity: 0.3;
            animation: animateDot 1.5s infinite;
        }

        @keyframes animateDot {
            0%, 80%, 100% {
                opacity: 0.3;
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
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
   
   <script>
        window.addEventListener('load', function () {
            var loader = document.getElementById('loader');
            if (loader) {
                loader.style.display = 'none';
            }
        });
    </script>
</body>
</html>
