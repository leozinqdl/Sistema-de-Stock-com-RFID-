<div class="page-title">Debulha</div>

<div>
     <?php
    $Redirect = new Redirect();
    $userModel = new userModel();
    $InputGenerate = new InputGenerate();
    $vet_user = $userModel->visualizeSelect($id_user_session);
    ?><div class="container_pages">
        <div class="redirect"><?
            $Redirect->redirectDrawList(null, null, "Bicas ", "badge", "off", "/spouts/insert");
            $Redirect->redirectDrawList(null, null, "Chifrudinho/Desemenda ", "badge", "off", "/hornanalysis/insert");
            $Redirect->redirectDrawList(null, null, "Debulha Manual ", "workers", "off", "/threshing/insert");
            $Redirect->redirectDrawList(null, null, "Config. Maquina ", "friends", "off", "/settingsmachine/insert");
            $Redirect->redirectDrawList(null, null, "Debulha Mecanica ", "friends", "off", "/mechanicalthreshing/insert");
            $Redirect->redirectDrawList(null, null, "Descarte ", "friends", "off", "/disposal/insert");
            $Redirect->redirectDrawList(null, null, "Final De Lotes ", "friends", "off", "/endbatch/insert");
            $Redirect->redirectDrawList(null, null, "Troca De Lotes ", "friends", "off", "/change/insert");
        ?></div>
    </div>
</div>
