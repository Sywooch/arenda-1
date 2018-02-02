<?php

namespace app\commands;

use SimpleXMLElement;
use app\models\CianMetro;
use app\models\CianArea;
use app\models\AvitoCity;
use app\models\AvitoDistrict;
use yii\console\Controller;

class ImportAddressEntitiesController extends Controller
{
	public function actionIndex()
	{
		$this->importCianMetro();
		$this->importCianMetro('?region=10', 10);
		$this->importCianRegions();
		$this->importAvitoCities();
	}
    
    protected function importCianMetro($params='', $region=1)
    {
		$url = 'https://www.cian.ru/metros.php' . $params;
		$xml = $this->getXml($url);
		foreach ($xml->children() as $child) {
			$id = strval($child->attributes()->id);
			$name = strval($child[0]);
			if (CianMetro::findOne(['cian_id' => $id, 'region_id' => $region]) == null) {
				$metro = new CianMetro();
				$metro->cian_id = $id;
				$metro->name = $name;
				$metro->region_id = $region;
				$metro->save(false);
			}
		}
	}
	
	protected function importCianRegions()
    {
		$url = 'https://www.cian.ru/admin_areas.php';
		$xml = $this->getXml($url);
		foreach ($xml->children() as $child) {
			$id = strval($child->attributes()->id);
			$name = strval($child[0]);
			if (CianArea::findOne(['cian_id' => $id]) == null) {
				$area = new CianArea();
				$area->cian_id = $id;
				$area->name = $name;
				$area->save(false);
			}
		}
	}
	
	protected function importAvitoCities()
    {
		$url = 'http://autoload.avito.ru/format/Locations.xml';
		$xml = $this->getXml($url);
		foreach ($xml->children() as $region) {
			foreach ($region->children() as $child) {
				if ($child->getName() == 'City') {
					$id = strval($child->attributes()->Id);
					$name = strval($child->attributes()->Name);
					if (AvitoCity::findOne(['avito_id' => $id]) == null) {
						$city = new AvitoCity();
						$city->avito_id = $id;
						$city->name = $name;
						$city->save(false);
					}
					$this->importAvitoDistricts($child, $id);
				}
			}
		}
	}
	
	protected function importAvitoDistricts($xml, $city_id)
    {
		foreach ($xml->children() as $child) {
			if ($child->getName() == 'District') {
				$id = strval($child->attributes()->Id);
				$name = strval($child->attributes()->Name);
				if (AvitoDistrict::findOne(['avito_id' => $id, 'city_id' => $city_id]) == null) {
					$district = new AvitoDistrict();
					$district->avito_id = $id;
					$district->city_id = $city_id;
					$district->name = $name;
					$district->save(false);
				}
			}
		}
	}
	
	protected function getXml($url)
	{
		return new SimpleXMLElement($url, 0, true);
	}
}
