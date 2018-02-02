<?php

use app\components\extend\Html;
?>

<?php

if ($nameKey) {
    echo '<br/>';
    $closeBt = Html::tag('a', '×', ['class' => 'pull-right close', 'onclick' => 'User.ProfileUpdate.Customer.deleteDuplicateFields($(this))']);
    echo Html::tag('h4', 'Дополнительная запись &numero; <span class="duplicate-counter">' . $nameKey . '</span>' . $closeBt);
}