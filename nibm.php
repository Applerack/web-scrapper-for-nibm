<?php

$Input = file_get_contents('php://input');
$Update = json_decode($Input, true);
$ChatID = $Update['message']['chat']['id'];
$name = $Update['message']['chat']['first_name'];
$Test = $Update['message']['id'];
$Message = $Update['message']['text'];

function sendmsg($message, $chatId) {
    $botToken = "enter_ur_token_here";
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $message
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

if($Message == "/start")
{
    sendmsg("Hello ".$name.", Send Your INDEX Number & i will send your results and gpa : )\n\nExample : MAHNDSE232F-077", $ChatID);
    die();
}


$indexNumber = $Message;
$cut = strrpos($indexNumber, '-');
if ($cut !== false) {
    $index = substr($indexNumber, 0, $cut);
}
switch ($index) {
    case "MAHNDSE241F":
        $batch = "7631";
        break;
    case "GAHNDSE241P":
         $batch = "7474";
        break;
    case "COHNDSE241F":
        $batch = "7450";
        break;
    case "COHNDSE233F":
        $batch = "7429";
        break;
    case "COHNDSE232F":
        $batch = "7396";
        break;
    case "MAHNDSE232F":
        $batch = "7350";
        break;
    case "MAHNDSE231F":
        $batch = "7178";
        break;
    case "COHNDSE231P":
        $batch = "6941";
        break;
        
    default:
       $batch ="";
}

if($batch == "")
{
     sendmsg($name." No Batch Found For Your Index!", $ChatID);
    die();
}
$batch = trim($batch);
$url = "https://www.nibmworldwide.com/exams/mis";


$headers = [
    "Host: www.nibmworldwide.com",
    "Cookie: _ga=GA1.2.1234167115.1718628688; _ga_8Y39KNRBM5=GS1.2.1719117165.3.1.1719117465.60.0.1393913265; _gid=GA1.2.621834888.1719086246; twk_uuid_5f6c82264704467e89f1ee75=%7B%22uuid%22%3A%221.92OhuoJzyzqLGQKAeDnPdVo9Th389HTNxsK7Hp8rEICBfvJMCj66FKLh2itHTOSFXosdqSjVF43jXTwRJUZW5ZlJfNr0kqm7eSXlFd6RDE3xn8TQMVbN7LKFUiLX%22%2C%22version%22%3A3%2C%22domain%22%3A%22nibmworldwide.com%22%2C%22ts%22%3A1719117462974%7D; TawkConnectionTime=0",
    "content-type: application/x-www-form-urlencoded",
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "sec-fetch-site: none",
    "accept-language: en-GB,en;q=0.9",
    "sec-fetch-mode: navigate",
    "origin: null",
    "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15",
    "sec-fetch-dest: document"
];

$postData = "F%5BProgramme%5D=2589&F%5BBatch%5D=".$batch."&F%5BStudent%5D=";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    sendmsg("Error While curl connection!", $ChatID);
    die();
}

curl_close($ch);
$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();
$xpath = new DOMXPath($dom);
$query = "//option[text()='$indexNumber']";
$options = $xpath->query($query);

if ($options->length > 0) {
  
    $value = $options->item(0)->getAttribute('value');
    
} else {
    sendmsg("Unable To FInd Id For Your Index!", $ChatID);
    die();
}





$url = "https://www.nibmworldwide.com/exams/mis";


$headers = [
    "Host: www.nibmworldwide.com",
    "Cookie: _ga=GA1.2.1234167115.1718628688; _ga_8Y39KNRBM5=GS1.2.1719117165.3.1.1719117465.60.0.1393913265; _gid=GA1.2.621834888.1719086246; twk_uuid_5f6c82264704467e89f1ee75=%7B%22uuid%22%3A%221.92OhuoJzyzqLGQKAeDnPdVo9Th389HTNxsK7Hp8rEICBfvJMCj66FKLh2itHTOSFXosdqSjVF43jXTwRJUZW5ZlJfNr0kqm7eSXlFd6RDE3xn8TQMVbN7LKFUiLX%22%2C%22version%22%3A3%2C%22domain%22%3A%22nibmworldwide.com%22%2C%22ts%22%3A1719117462974%7D; TawkConnectionTime=0",
    "content-type: application/x-www-form-urlencoded",
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "sec-fetch-site: none",
    "accept-language: en-GB,en;q=0.9",
    "sec-fetch-mode: navigate",
    "origin: null",
    "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.5 Safari/605.1.15",
    "sec-fetch-dest: document"
];

$postData = "F%5BProgramme%5D=2589&F%5BBatch%5D=".$batch."&F%5BStudent%5D=".$value;

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

$response = curl_exec($ch);

$dom = new DOMDocument();
@$dom->loadHTML($response);


$rows = $dom->getElementsByTagName('tr');
$subjects = [];
foreach ($rows as $row) {
 
    $cells = $row->getElementsByTagName('td');
    if ($cells->length >= 8) { 
        $subject = [
            'Subject' => trim($cells->item(1)->nodeValue),
            'Exam' => $cells->item(4)->nodeValue,
            'Course Work' => $cells->item(5)->nodeValue,
            'Final Grade' => $cells->item(6)->nodeValue,
            'Points' => floatval($cells->item(7)->nodeValue)
        ];
        $subjects[] = $subject;
    }
}


$creditHours = [
    'HNDSE23.2F/MT/Programming Data Structures and Algorithms-1' => 3,
    'HNDSE23.2F/MT/Advanced Database Management Systems' => 3,
    'HNDSE23.2F/MT/Statistics for Computing' => 3,
    'HNDSE23.2F/MT/Internet of Things' => 3,
    'HNDSE23.2F/MT/Mobile Application Development' => 3,
    'HNDSE23.2F/MT/Data Warehousing and Data Mining' => 3,
    'HNDSE23.2F/MT/Enterprise Application Development-2' => 3,
    'HNDSE23.2F/MT/Robotic Application Development' => 4,
    'HNDSE23.2F/MT/IT Management Practice' => 2,
    'HNDSE23.2F/MT/Software Security' => 3,
    'HNDSE23.2F/MT/Machine Learning for Artificial Intelligence' => 3,
    'HNDSE23.2F/MT/Digital Image Processing' => 3,
    'HNDSE23.2F/MT/Innovation and Entrepreneurship Project' => 4,
    'HNDSE23.2F/MT/Industrial Training' => 5
];


$totalPoints = 0;
$totalCreditHours = 0;
foreach ($subjects as $subject) {
    $subjectName = $subject['Subject'];
    if (isset($creditHours[$subjectName])) {
        $points = $subject['Points'];
        $creditHour = $creditHours[$subjectName];
        $totalPoints += $points * $creditHour;
        $totalCreditHours += $creditHour;
    }
}

$finalGPA = $totalCreditHours > 0 ? $totalPoints / $totalCreditHours : 0;

$textMessage = '';
foreach ($subjects as $index => $subject) {
    $textMessage .=  $subject['Subject'] . "\n";
    $textMessage .= "Exam: " . $subject['Exam'] . "\n";
    $textMessage .= "Course Work: " . $subject['Course Work'] . "\n";
    $textMessage .= "Final Grade: " . $subject['Final Grade'] . "\n";
    $textMessage .= "Points: " . $subject['Points'] . "\n\n";
}

$textMessage .= "✅ Final GPA: " . number_format($finalGPA, 2) . "\n";
sendmsg($textMessage, $ChatID);








?>
