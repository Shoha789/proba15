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

function getFullnameFromParts($surname, $name, $patronymic) {
    return "$surname $name $patronymic";
}
$getFullnameFromParts = getFullnameFromParts("Иванов","Иван","Иванович");
echo $getFullnameFromParts;
echo "\n";

function getPartsFromFullname($fullname) {
    $parts = explode(' ', $fullname);

    $result = [
        'surname' => $parts[0],
        'name' => $parts[1],
        'patronomyc' => $parts[2]
    ];

    return $result;
}
$fullname = 'Иванов Иван Иванович';
$getPartsFromFullname = getPartsFromFullname($fullname);

print_r($getPartsFromFullname);
echo "\n";


function getShortName($fullName) {
    $names = explode(" ", $fullName); 
    $firstName = $names[1]; 
    $lastName = mb_substr($names[0], 0, 1);
    return $firstName . " " . $lastName . ".";
}

$getShortName = getShortName("Иванов Дмитрий Иванович");
echo $getShortName;
echo "\n";

function getGenderFromName($fullname1) {
    $parts = getPartsFromFullname($fullname1);

    $genderScore = 0;

    if (mb_substr($parts['patronomyc'], -3) == 'вна') {
        $genderScore--;
    }
    if (mb_substr($parts['name'], -1) == 'а' or 'я') {
        $genderScore--;
    }
    if (mb_substr($parts['surname'], -2) == 'ва') {
        $genderScore--;
    }

    
    if (mb_substr($parts['patronomyc'], -2) == 'ич') {
        $genderScore++;
    }
    if (mb_substr($parts['name'], -1) == 'й' or 'н' ) {
        $genderScore++;
    }
    if (mb_substr($parts['surname'], -1) == 'в') {
        $genderScore++;
    }

    if ($genderScore > 0) {
        return 1;
    } elseif ($genderScore < 0) {
        return -1;
    } else {
        return 0; 
    }
}
$fullname1 = 'Цой Лилит Дмитриевна';
$gender = getGenderFromName($fullname1);
echo $fullname1 . ' ' ;
if ($gender === 1) {
    echo '- Мужской пол';
} elseif ($gender === -1) {
    echo '- Женский пол';
} else {
    echo '- Неопределенный пол';
}
echo "\n";
function getGenderProsent($example_persons_array) {
    $a = count($example_persons_array);
    $b = 0;
    $female = 0;
    $male = 0;
    $uncknow = 0;
    $gender = getGenderFromName($example_persons_array[$b]['fullname']);
    for ($b; $b < $a; $b++) {
        $gender = getGenderFromName($example_persons_array[$b]['fullname']);
    if ($gender == -1){
        $female++;
       } elseif ($gender == 1) {
        $male++;
       } else  {
        $uncknow++;
       }

    }
    $z = round($female/$a*100,1);
    $m = round($male/$a*100,1);
    $un = round($uncknow/$a*100,1);
    
    
    echo "Гендерный состав аудитории:";
    echo "\n";
    echo "Женщины - " .' ' . $z . '%';
    echo "\n";
    echo "Мужчины - " . ' ' . $m . '%';
    echo "\n";
    echo "Неопределено - " . ' ' . $un . '%';
}

print_r(getGenderProsent($example_persons_array));
echo "\n";

function getPerfectPartner($surname, $name, $patronymic, $persons_array) {
    $fullname = mb_convert_case(getFullnameFromParts($surname, $name, $patronymic), MB_CASE_TITLE_SIMPLE);
    $gender = getGenderFromName($fullname);
    
    do {
        $random_person = $persons_array[array_rand($persons_array)];
        $partner_fullname = $random_person['fullname'];
        $partner_gender = getGenderFromName($partner_fullname);
    } while ($gender == $partner_gender);
    
    $compatibility = rand(5000, 10000) / 100;
    
    return $fullname . ' + ' . $partner_fullname . ' = ' .
           "♡ Идеально на " . number_format($compatibility, 2) . "% ♡";
};
$result = getPerfectPartner('Иванова', 'вероника', 'Дмитриевна', $example_persons_array);
echo $result;