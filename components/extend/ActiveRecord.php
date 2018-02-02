<?php

namespace app\components\extend;

use yii;
use app\models\Notifications;
use app\components\helpers\CommonHelper;

class ActiveRecord extends \yii\db\ActiveRecord
{
    const SCENARIO_FILE_UPLOAD = 'fileUpload';
    const SCENARIO_NOTE_ADMIN_OF_ERRORS = 'note_admins_of_errors';

    /**
     * get model rule param value 
     * @param string $attribute
     * @param string $method
     * @param string $param
     * @param mixed $alternative
     * @return mixed
     */
    public function getRuleParam($attribute, $method, $param, $alternative = null)
    {
        foreach ($this->rules() as $k => $v) {
            if (($v[0] == $attribute || (is_array($v[0]) && in_array($attribute, $v[0]))) && $v[1] == $method) {
                if (array_key_exists($param, $v)) {
                    $result = $v[$param];
                }
                break;
            }
        }
        return isset($result) ? $result : $alternative;
    }

    /**
     * note administration about errors while saving model
     */
    public function noteAdminsOfErrors()
    {
        Notifications::messageAdmins(yii::t('yii', 'Ошибка о которой должен знать администратор:<br/> {error}', [
                    'error' => CommonHelper::formatModelErrors($this),
        ]));
    }

    /**
     * 
     * @return boolean
     */
    public function fakeRule()
    {
        return true;
    }

	/**
	 *
	 * @param type $dateAttribute
	 * @param type $format
	 * @return type
	 */
	public function getDate($dateAttribute, $format = 'U')
	{
		if (!$this->$dateAttribute) {
			return null;
		}

		$date = $this->$dateAttribute;

		if (strpos($date, '.') !== FALSE) {
			$date = strtotime($date);
		}

		if ($format === 'U') {
			return date($format, $date);
		}

		return date($format, $date);
	}

    /**
     * get date-time
     * @param type $dateAttribute
     * @param type $format
     * @return type
     */
    public function getDateTime($dateAttribute, $format = 'medium')
    {
        if (!$this->{$dateAttribute}) {
            return null;
        }
        if ($format === 'U') {
            return date($format, $this->{$dateAttribute});
        }
        return yii::$app->formatter->asDatetime($this->{$dateAttribute}, $format);
    }

    /**
     * return yes if value is 1 in all other cases result is no
     * @param integer $value
     * @return string
     */
    public function getYesNo($value)
    {
        return (int) $value === 1 ? 'Да' : 'Нет';
    }

}
