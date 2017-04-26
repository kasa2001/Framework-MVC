<header>

</header>
<nav>
    <?= $this->loadA("Return to index", "home/index") ?>
</nav>
<article>
    <form method="post">
        <input name="nick" type="text" placeholder="nick">
        <input name="password" type="password" placeholder="password">
        <button>Register</button>
        <button>Login</button>
    </form>
</article>