<?php
session_start();
if(isset($_SESSION['username'])) {

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice</title>
    <link rel="stylesheet" href="../../assets/backstyle.css">
    <link rel="stylesheet" href="../../assets/backresponsive.css">
</head>

<body>

    <header>

        <div class="logosec">
            <h2 class="logo">youCommerce</h2>

        </div>

        <div class="searchbar">
        <input type="text" placeholder="Buscar">
        <div class="searchbtn">
            <svg width="36px" height="36px" viewBox="0 0 48 48" fill="currentColor" 
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                 d="m42.501 42.5l-7.351-7.776a17.244 17.244 0 1 0-7.075 4.422"/></g>
            </svg>
        </div>
        </div>

        <div class="message">
            <div class="circle"></div>
            <svg width="36px" height="36px" viewBox="0 0 48 48" fill="currentColor" 
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="none" 
                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                d="M40.462 32.173c-2.53-1.967-2.918-2.596-4.611-11.571c-1.438-7.623-4.59-9.993-8.504-11.232c.217-.47.347-.99.347-1.543a3.694
                3.694 0 0 0-7.388 0c0 .553.13 1.072.347 1.543c-3.913 1.24-7.066 3.61-8.504 11.232c-1.693 8.975-2.08 9.604-4.61 11.57c-2.614
                2.032-2.53 6.71.948 6.71h10.464c.04 2.76 2.281 4.985 5.049 4.985s5.01-2.226 5.049-4.984h10.463c3.479 0 3.563-4.68.95-6.71Z"/></g>
            </svg>
            <div class="dp">
            <svg width="36px" height="36px" viewBox="0 0 1200 1200" fill="currentColor" x="128" y="128" role="img"
                xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="currentColor" d="M605.096 
                480c-135.542-2.098-239.082-111.058-239.999-240C367.336 105.667 477.133.942 605.096 0c135.662 5.13 
                239.036 108.97 240.001 240c-2.668 134.439-111.907 239.09-240.001 240zm194.043 49.788c170.592 1.991 
                257.094 151.63 257.881 301.269V1200H889.784l.001-324.254c-4.072-22.416-19.255-30.018-33.164-27.82c-13.022
                2.059-24.929 12.701-25.56 27.82V1200h-464.67V875.746c-3.557-21.334-17.128-29.537-30.331-28.709c-14.138.889-27.853
                12.135-28.393 28.709V1200h-164.68V831.057c-.98-159.475 99.901-300.087 259.137-301.269h397.015z"/></g>
        </svg>
        </div>
        </div>

    </header>

</body>

</html>

<?php
} else {
    header('Location: index.html');
    exit();
}
?>