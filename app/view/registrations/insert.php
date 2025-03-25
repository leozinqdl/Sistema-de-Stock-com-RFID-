<div class="page-title">Cadastros</div>

<div>
     <?php
    $Redirect = new Redirect();
    $userModel = new userModel();
    $InputGenerate = new InputGenerate();
    $vet_user = $userModel->visualizeSelect($id_user_session);
    ?><div class="container_pages">
        <div class="redirect"><?
            $Redirect->redirectDrawList(null, null, "Semente Debulhada", "badge", "off", "/whichpallet/insert");
            $Redirect->redirectDrawList(null, null, "Cebola", "workers", "off", "");
            $Redirect->redirectDrawList(null, null, "Alho", "friends", "off", "");
        ?></div>
    </div>
</div>
