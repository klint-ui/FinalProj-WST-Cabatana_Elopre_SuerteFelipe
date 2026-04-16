<?php
$xmlFile = 'students.xml';

// Helper to load XML safely
function getXML($file) {
    if (!file_exists($file)) {
        file_put_contents($file, '<student_list></student_list>');
    }
    return simplexml_load_file($file);
}

// --- READ (API Endpoint) ---
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['delete'])) {
    $students = getXML($xmlFile);
    header('Content-Type: application/json');
    echo json_encode($students);
    exit;
}

// --- CREATE ---
if (isset($_POST['add'])) {
    $students = getXML($xmlFile);
    $student = $students->addChild('student');
    $student->addChild('id', htmlspecialchars($_POST['id']));
    $student->addChild('name', htmlspecialchars($_POST['name']));
    $student->addChild('course', htmlspecialchars($_POST['course']));
    $students->asXML($xmlFile);
    header("Location: index.html");
    exit;
}

// --- DELETE ---
if (isset($_GET['delete'])) {
    $students = getXML($xmlFile);
    $id = $_GET['delete'];
    $i = 0;
    foreach ($students->student as $st) {
        if ($st->id == $id) {
            unset($students->student[$i]);
            break;
        }
        $i++;
    }
    $students->asXML($xmlFile);
    header("Location: index.html");
    exit;
}

// --- UPDATE ---
if (isset($_POST['update'])) {
    $students = getXML($xmlFile);
    foreach ($students->student as $student) {
        if ($student->id == $_POST['id']) {
            $student->name = htmlspecialchars($_POST['name']);
            $student->course = htmlspecialchars($_POST['course']);
            break;
        }
    }
    $students->asXML($xmlFile);
    header("Location: index.html");
    exit;
}