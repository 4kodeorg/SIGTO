<?php
include('header-index.php');
?>

<section class="error-section">
    <article class="error-page">
        <div class="image-container">
            <?php if (isset($data)) {
                echo '<img src="../assets/imgs/errpage.svg" alt="">
                <h5 class="error"> ' . $data['message'] . '</h5>';
            } else {
                echo '<img src="../assets/imgs/notfop.svg" alt="">
                    <h5 class="error">Parece que estás perdido!</h5>';
            }
            ?>

        </div>
      
    </article>
    <a
        class="error-link"
        href="/home">
        Volver al inicio
    </a>
</section>

<?php
include('footer.php');
