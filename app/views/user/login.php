<header>

</header>
<nav>
    <?= $this->buildLink("Return to index", "home/index") ?>
</nav>
<article>
    <?= $this->startForm("home/index");?>
        <input name="nick" type="text" placeholder="nick">
        <input name="password" type="password" placeholder="password">
        <button>Register</button>
        <button>Login</button>
    <?= $this->endForm();?>
</article>