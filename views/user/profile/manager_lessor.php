<?php

?>

<?= $this->render('_header', [
    'user'             => $user,
    'info'             => $info,
    'inviteLessorForm' => $inviteLessorForm,
    'inviteCustomerForm' => $inviteCustomerForm,
    'realEstate'       => $realEstate,
]); ?>

<div class="col col-1">

    <?= $this->render('_common', [
        'user'             => $user,
        'info'             => $info,
        'inviteLessorForm' => $inviteLessorForm,
        'inviteCustomerForm' => $inviteCustomerForm,
        'inviteCustomerForm' => $inviteCustomerForm,
        'realEstate'       => $realEstate,
        'model'       => $model,
    ]); ?>

    <?php
    $dataProvider = $user->getMyActiveAds();

    if ($dataProvider->getTotalCount() > 0) {
        echo $this->render('../info_card_manager', [
            'model'        => $info,
            'user'         => $user,
            'dataProvider' => $dataProvider,
        ]);
    }
    ?>
</div>

