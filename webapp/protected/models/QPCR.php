<?php

class QPCR
{

	private $experimentId;

	public $data = array();
    public $results = array();
	public $treatmentCodes = array();
    public $genes = array();
    public $numSamples = array();
    public $ommittedSamples = array();

    public $avgByGenderGroupJson;
    public $resultsByBothJson;
    public $sumByBothJson;

    public function __construct($experimentId)
    {
    	$this->experimentId = $experimentId;
    }

    public function processData()
    {
    	$treatment = Experiment::model()->with('dataSets', 'dataSets.columnMappings')->findByPk($this->experimentId);

    	foreach ($treatment->dataSets as $dataSet)
    	{

            if ($dataSet->type == 'Codes')
            {
                $rows = Yii::app()->db->createCommand()->select()->from($dataSet->tableName)->queryAll();

                foreach ($rows as $row)
                {
                    //print_r($row);
                    if (count($row) == 3)
                    {
                        $id = strtolower($row['column1']);
                        $gender = $row['column2'];
                        $group = $row['column3'];

                        $this->treatmentCodes[$id] = array('gender' => $gender, 'group' => $group);
                        //print_r($this->data['code'][$id]);
                    }
                }
            }
    	}

        foreach ($treatment->dataSets as $dataSet)
        {
            if ($dataSet->type == 'Data')
            {
                $rows = Yii::app()->db->createCommand()->select()->from($dataSet->tableName)->queryAll();

                foreach ($rows as $row)
                {
                    if (count($row) == 28)
                    {
                        $id = $row['column2'];
                        $value = $row['column10'];
                        $gene = $row['column3'];
                        $ctsd = $row['column12'];
                        $noamp = $row['column27'];
                        $expfail = $row['column28'];
                        $well = $row['column1'];

                        if ($ctsd >= .5 || strtolower($noamp) === 'y' || strtolower($expfail) === 'y')
                        {
                            $this->ommittedSamples[$well . ' - ' . $id] = $value;
                        } 
                        else if (!empty($id) && !empty($value) && !empty($this->treatmentCodes[$id]))
                        {
                            $this->data[] = array(
                                'id' => $id, 
                                'value' => $value,
                                'gender' => $this->treatmentCodes[$id]['gender'],
                                'group' => $this->treatmentCodes[$id]['group']);

                            $this->genes[$gene] = true;
                        }
                    }
                }
            }
        }

        foreach ($this->data as $r)
        {
            if (is_numeric($r['value']))
            {

                /*
                if (!isset($this->results[$r['group']]))
                {
                    $this->results[$r['group']] = array();
                }

                if (!isset($this->results[$r['group']][$r['gender']]))
                {
                    $this->results[$r['group']][$r['gender']] = array();
                }

                $this->results[$r['group']][$r['gender']][] = $r['value'];
                */

                if (!isset($this->results[$r['gender']]))
                {
                    $this->results[$r['gender']] = array();
                }

                if (!isset($this->results[$r['gender']][$r['group']]))
                {
                    $this->results[$r['gender']][$r['group']] = array();
                }

                $this->results[$r['gender']][$r['group']][] = $r['value'];

                if (!isset($this->numSamples[$r['group'] . ' ' . $r['gender']]))
                {
                    $this->numSamples[$r['group'] . ' ' . $r['gender']] = 0;
                }

                $this->numSamples[$r['group'] . ' ' . $r['gender']]++;
            }

        }

        $emptyJson = '{}';

        $avgByGenderGroupJsonObj = json_decode($emptyJson);
        $avgByGenderGroupJsonObj->data = array();

        $resultsByBothJsonObj = json_decode($emptyJson);
        $resultsByBothJsonObj->data = array();
        $resultsByBothCtr = 1;

        $sumbByBothJsonObj = json_decode($emptyJson);
        $sumbByBothJsonObj->data = array();

        foreach ($this->results as $gender => $resultsByGender)
        {
            $genderJson = json_decode($emptyJson);
            $genderJson->key = $gender;
            $genderJson->values = array();

            foreach ($resultsByGender as $group => $values)
            {

                // json result #1

                $groupJson = json_decode($emptyJson);
                $groupJson->x = $group;
                $groupJson->y = array_sum($values)/count($values);

                $genderJson->values[] = $groupJson;

                // json result #2

                $comboJson = json_decode($emptyJson);
                $comboJson->key = $gender . ' ' . $group;
                $comboJson->values = array();

                $baseJson = json_decode($emptyJson);
                $baseJson->x = 1;
                $baseJson->y = 0;
                $baseJson->size = 1;

                $comboJson->values[] = $baseJson;

                foreach ($values as $v)
                {
                    $newPointJson = json_decode($emptyJson);
                    $newPointJson->x = $resultsByBothCtr;
                    $newPointJson->y = $v;
                    $newPointJson->size = 10;

                    $comboJson->values[] = $newPointJson;
                }

                $resultsByBothJsonObj->data[] = $comboJson;
                $resultsByBothCtr++;

                //json result #3

                $sumJson = json_decode($emptyJson);
                $sumJson->key = $gender . ' - ' . $group;
                $sumJson->y = array_sum($values);

                $sumbByBothJsonObj->data[] = $sumJson;

            }

            $avgByGenderGroupJsonObj->data[] = $genderJson;

            
        }

        $this->avgByGenderGroupJson = json_encode($avgByGenderGroupJsonObj);

        $this->resultsByBothJsonJson = json_encode($resultsByBothJsonObj);

        $this->sumByBothJson = json_encode($sumbByBothJsonObj);

        //print_r($this->sumByBothJson);
        //print_r($this->avgByGenderGroup);

        /*
data: [
{
key: "Female Control",
values: [
{
x: 1,
y: 0,
size: 1
},
{
x: 1,
y: 1,
size: 10
},
{
x: 1,
y: 2,
size: 10
},
{
x: 1,
y: 3,
size: 10
}
]
},
}*/


        //echo json_encode($this->avgByGenderGroup);
        
    }

}