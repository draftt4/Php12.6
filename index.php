<!Document html>
<html>
    <meta charset="UTF-8">

<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];


foreach($example_persons_array as $person){
    $person_full_names = getPartsFromFullname($person);
    $person_string_name = getFullnameFromParts($person_full_names);
    $short_name = getShortName($person_string_name);
    $person_gender = getGenderFromName($person_string_name);
    var_dump($person_gender);

}

getGenderDescription($example_persons_array);


function getPartsFromFullname(array $person):array
{
    $collection = explode(' ', $person['fullname']);
    return [
        'surname' => $collection[0],
        'name' => $collection[1],
        'patronomyc' => $collection[2]
    ];
    
}

function getFullnameFromParts(array $person):string
{
    return implode(' ', $person);

}

function getShortName(string $person):string
{
    $name = explode(' ', $person);
    $short_name = $name[1].' '.mb_substr($name[2], 0, 1).'.';
    return $short_name;
}
// фунция определение пола
function getGenderFromName (string $person_full_name):int{
    $gender = 0;

    $name_arry = explode(' ', $person_full_name);

     foreach($name_arry as $key => $name){
        
        $last_letter = mb_substr($name,-1);
        $last_two_letters = mb_substr($name,-2);
        $last_tree_letters = mb_substr($name,-3);

        if($key == 2){
            if($last_two_letters == 'ич'){
                $gender++;
            }

            if($last_tree_letters == 'внa'){
                $gender--;
            }
        }
        
        if($key == 1){
            if($last_letter == "й" || $last_letter == "н"){
                $gender++;
            }
            if($last_letter == "а"){
                $gender--;
            }
        }
        
        if($key == 0){

            if($last_letter == 'в'){
                $gender++;
            }

            if($last_two_letters == 'вa'){
                $gender--;
            }
        
        }

     }
     

    if ($gender > 0) {
        $gender = 1; // мужского пола
    }elseif ($gender < 0) {
        $gender = -1; // женского пола
    }else{
        $gender = 0; // неопределенный пол
    }

    return $gender;
}

// функция определение определения полового состава аудитории
function getGenderDescription (array $example_persons_array) {
    $male = 0;
    $female = 0;
    $unknow = 0;
    $all = count($example_persons_array);

    foreach($example_persons_array as $person_full_name){
        $gender = getGenderFromName($person_full_name["fullname"]);
        
        if ($gender === 1){
            $male++;
        } elseif ($gender === -1){
            $female++;
        } else {
            $unknow++;
        }
    }

    $count1 = ($male / $all) * 100;
    $male_percent = number_format($count1, 1,);

    $count1 = ($female / $all) * 100;
    $female_percent = number_format($count1, 1,);

    $count1 = ($unknow / $all) * 100;
    $unknow_percent = number_format($count1, 1,);
    


    echo 'Гендерный состав аудитории:';
    echo  '<br>';
    echo 'Мужчины - '.$male_percent.' %'; // процент мужской пол
    echo  '<br>';
    echo 'Женщины - '.$female_percent.' %';// процент женского пол
    echo  '<br>';
    echo 'Не удалось определить -'.$unknow_percent.' %'; // процент неопределенный пол
}

//функция для определения «идеальной» пары
function getPerfectPartner(array $data, int $repeat = 1) {
    $data = array_values($data); 
    $result = []; // Контейнер с результатом

    foreach ($example_persons_array as $outerKey => $outerElement) {
        $internalData = array_slice($data, $outerKey + 1); 
        foreach ($internalData as $innerKey => $innerElement) {
            $pair = [$outerElement, $innerElement]; 
            $result[] = $pair;

            if ($repeat > 1) {
                $reversedPair = [$innerElement, $outerElement]; 

                for ($i = 2; $i <= $repeat; $i++) {
                    $result[] = ($i % 2 == 0) ? $reversedPair : $pair;
                }
            }
        }
    }

    return $result;
}


?>
</html>