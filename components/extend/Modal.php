<?php

namespace app\components\extend;

use yii;
use yii\bootstrap\Modal as BaseModal;

class Modal extends BaseModal
{

    /**
     * 
     * @return type
     */
    protected function initOptions()
    {
        $io = parent::initOptions();
        $this->headerTransform();
        $this->options['class'] .= ' system-default-modal';
        return $io;
    }

    public function headerTransform()
    {
        if ($this->header) {
            $this->header = Html::tag('h2', $this->header, ['class' => 'text-center']);
        }
    }

}
