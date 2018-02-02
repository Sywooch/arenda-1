<?php

namespace app\components\extend;

use yii;

class FileInput extends \kartik\file\FileInput
{
    public $pluginOptions = [
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false
    ];

    /**
     * @var bool whether to resize images on client side
     */
    public $resizeImages = false;

    /**
     * @var bool whether to load sortable plugin to rearrange initial preview images on client side
     */
    public $sortThumbs = true;

    /**
     * @var bool whether to load dom purify plugin to purify HTML content in purfiy
     */
    public $purifyHtml = true;

    /**
     * @var bool whether to show 'plugin unsupported' message for IE browser versions 9 & below
     */
    public $showMessage = true;

    /*
     * @var array HTML attributes for the container for the warning
     * message for browsers running IE9 and below.
     */
    public $messageOptions = ['class' => 'alert alert-warning'];

    /**
     * @var array the internalization configuration for this widget
     */
    public $i18n = [];

    /**
     * @inheritdoc
     */
    public $pluginName = 'fileinput';

    /**
     * @var array the list of inbuilt themes
     */
    private static $_themes = ['fa', 'gly'];

}