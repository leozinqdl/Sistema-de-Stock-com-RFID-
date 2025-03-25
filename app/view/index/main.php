<?php
$Redirect = new Redirect();
$userModel = new userModel();
$InputGenerate = new InputGenerate();
$vet_user = $userModel->visualizeSelect($id_user_session);

?><div class="container_pages"><?
    ?><div class="redirect"><?
        $Redirect->redirectDraw(null, null, "Debulha", "garlic", "off", "/shed/insert");
        $Redirect->redirectDraw(null, null, "Cebola", "onion", "off", "/onion/insert");
        $Redirect->redirectDraw(null, null, "Alho", "garlic", "off", "/garlic/insert");
        $Redirect->redirectDraw(null, null, "Câmara Fria", "icecube", "off", "/coldroom/insert");
        $Redirect->redirectDraw(null, null, "Cadastros", "registrations", "off", "/registrations/insert");
    ?></div>
</div>
