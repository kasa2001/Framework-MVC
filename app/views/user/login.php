<header>

</header>
<nav>
    <?= $this->buildLink("Return to index", "home/index") ?>
</nav>
<article>
    <?= $this->startForm("home/index");?>
        <input name="nick" type="text" placeholder="nick">
        <input name="password" type="password" placeholder="password">
        <?=$this->loginButton("Logowanie");?>
        <?=$this->registryButton("Rejestracja");?>
    <?= $this->endForm();?>
</article>