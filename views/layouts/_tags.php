<?php

use app\components\helpers\CommonHelper;
?>

<?=

CommonHelper::str()->replaceTagsWithDatatValues($content, [
    'signup_form' => Yii::$app->user->isGuest ? $this->render('_blocks/registration-section', [
                'model' => new app\models\forms\SignupForm()
            ]) : ''
]);
?>