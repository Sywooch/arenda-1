<?php
/**
 * @author alexk984
 */

namespace app\components;


use Sunra\PhpSimple\HtmlDomParser;

/**
 * Парсинг документа с данными о Правообладателях
 *
 * Class XZPDocumentParser
 * @package app\components
 */
class XZPDocumentParser
{
    public $owners = [];
    public $registration_law_kind;
    public $registration_law_number;
    public $registration_law_date;
    public $encumbrance;
    public $seizure;
    public $third_party_problem;

    /**
     * @param string $html
     * @throws \Exception
     */
    public function parse($html)
    {
        $dom = HtmlDomParser::str_get_html($html);
        foreach ($dom->find('td') as $key => $td) {
            $text = $td->text();
            echo $text . PHP_EOL;
            if ($text == "Правообладатель (правообладатели):") {
                $owners_key = $key + 2;
            } elseif ($text == "Вид, номер и дата государственной регистрации права:") {
                $registration_key = $key + 2;
            } elseif ($text == "Ограничение прав и обременение объекта недвижимости:") {
                $encumbrance_key = $key + 1;
            } elseif ($text == "Сведения о наличии решения об изъятии объекта недвижимости для государственных и муниципальных нужд:") {
                $seizure_key = $key + 1;
            } elseif ($text == "Сведения об осуществлении государственной регистрации прав без необходимого в силу закона согласия третьего лица, органа:") {
                $third_party_problem_key = $key + 1;
            }

            if (isset($owners_key) && $owners_key == $key) {
                $owners = $text;
            }
            if (isset($registration_key) && $registration_key == $key) {
                $registration = $text;
            }
            if (isset($encumbrance_key) && $encumbrance_key == $key) {
                $this->encumbrance = $text;
            }
            if (isset($seizure_key) && $seizure_key == $key) {
                $this->seizure = $text;
            }
            if (isset($third_party_problem_key) && $third_party_problem_key == $key) {
                $this->third_party_problem = $text;
            }
        }

        if (!isset($owners) || !isset($registration) || !$this->encumbrance || !$this->seizure || !$this->third_party_problem)
            throw new \Exception('Parsing Cadastr error: ' . $html);

        $this->parseOwners($owners);
        $this->parseRegistrationData($registration);
    }

    /**
     * Парсинг собственников
     * @param string $owners
     */
    private function parseOwners($owners)
    {
        $owners = explode(';', $owners);
        foreach ($owners as $owner)
            $this->owners[] = trim($owner);
    }

    /**
     * Парсинг "Вид, номер и дата государственной регистрации права"
     * Пример: Совместная собственность, № 34-34/001-34/001/132/2016-47/2 от 23.08.2016
     * @param string $registration
     * @throws \Exception
     */
    private function parseRegistrationData($registration)
    {
        preg_match('/(.+)\, № (.+) от(.+)/', $registration, $matches);
        if (count($matches) < 4)
            throw new \Exception('Error while parsing registration data: ' . $registration);
        $this->registration_law_kind = $matches[1];
        $this->registration_law_number = $matches[2];
        $this->registration_law_date = date("Y-m-d", strtotime($matches[3]));
    }
}