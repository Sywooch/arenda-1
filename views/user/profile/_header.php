<?php
use app\components\extend\Url;

?>

<?php if ($user->id == Yii::$app->user->id): ?>
    <div class="lk-profile-t-2">
        <h1 class="lk-profile-t-2__title">Ваш профиль</h1>
        <div class="lk-profile-t-2__btns btn_two_var-1">
            <a href="<?= Url::to(['/user/profile-update']); ?>" class="item">Редактировать профиль</a>
            <a class="item active js-modal-link" data-id-modal="shareProfile" href="#">
                <?= ($user->isCustomer) ? 'Рассказать друзьям' : 'Рассказать друзьям' ?>
            </a>
            <?php
            if($user->isCustomer){
                echo $this->render('customer/_share_profile_customer_modal', [
                    'user'             => $user,
                    'info'             => $info,
                    'inviteLessorForm' => $inviteLessorForm,
                    'inviteCustomerForm' => $inviteCustomerForm,
                    'realEstate'       => isset($realEstate) ? $realEstate : null,
                ]);
            }else{
                echo $this->render('customer/_share_profile_lessor_modal', [
                    'user'             => $user,
                    'info'             => $info,
                    'inviteLessorForm' => $inviteLessorForm,
                    'inviteCustomerForm' => $inviteCustomerForm,
                    'realEstate'       => $realEstate,
                ]);
            }

            ?>
        </div>
    </div>
<?php endif; ?>