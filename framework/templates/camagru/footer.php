<?
global $USER;
?>
    </main>
    <footer>
        <div class="nav-footer">
            <a href="https://github.com/kagestonedragon/camagru/" target="_blank"><img src="/markups/images/github.png"></a>
        </div>
    </footer>

    <?if ($USER->isAuthorized()) :?>
        <div class="posts__item-new">
            <a href="/items/add/"><i class="fas fa-plus"></i></a>
        </div>
    <?endif;?>

    <script src="/markups/js/event_listeners.js"></script>
</body>
</html>