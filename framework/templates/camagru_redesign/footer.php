<?
global $USER;

$userLink = '/u/' . $USER->getUsername() . '/';
?>
</main>
<footer>
    <nav class="nav-footer">
        <a href="/notifications/">
            <div id="icon-notifications-mobile">
                <i class="far fa-bell icons"></i>
            </div>
        </a>
        <a href="/add/">
            <div id="icon-add-mobile">
                <i class="fas fa-plus icons"></i>
            </div>
        </a>
        <!--
        <a href="/notifications/">
            <div id="icon-notifications-new">
            <i class="fas fa-bell icons"></i>
        </div>
        </a>
        -->
        <a href="<?=$userLink?>">
            <div class="nav__item-user" id="icon-user-mobile">
                <img src="/markups/images/photo.jpg">
            </div>
        </a>
    </nav>
</footer>
<script>
    const button = document.getElementById('button');
    const preloader = document.getElementById('preloader');

    button.addEventListener('click', function(e) {
        e.preventDefault();
        button.style.display = 'none';
        preloader.style.display = 'block';
    })
</script>
</body>
</html>