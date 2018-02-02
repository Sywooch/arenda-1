<?php

use app\components\extend\Html;

$this->title = 'Dashboard';
?>
<?= Html::tag('h1', 'Hello to admin page'); ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Header</th>
            <th>Header2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Cell</td>
            <td>Cell</td>
        </tr>
        <tr>
            <td>Cell</td>
            <td>Cell</td>
        </tr>

    </tbody>
</table>