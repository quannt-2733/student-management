<?php
// Bien ket noi toan cuc
global $conn;

// Ham ket noi database
function connectDatabase()
{
    // Goi toi bien toan cuc $conn
    global $conn;

    // Neu chua ket noi thi thuc hien ket noi
    if (!$conn) {
        $conn = mysqli_connect('localhost', 'root', '123456', 'student_management') or die('Can\'t not connect to database');
        mysqli_set_charset($conn, 'utf8');
    }
}
 
// Ham ngat ket noi
function disconnectDatabase()
{
    // Goi toi bien toan cuc $conn
    global $conn;
     
    // Neu da ket noi thi thuc hien ngat ket noi
    if ($conn) {
        mysqli_close($conn);
    }
}

function getAllStudents()
{
    // Goi toi bien toan cuc $conn
    global $conn;

    $result = [];
    $newArray = [];
    $counter=0;

    connectDatabase();

    $sql = 'SELECT students.*, class.name AS class_name, subjects.name AS subject_name, student_subjects.score
                FROM students 
                INNER JOIN student_subjects ON student_subjects.id_student = students.id
                INNER JOIN subjects ON subjects.id = student_subjects.id_subject
                INNER JOIN class ON students.id_class = class.id';

    // Thuc hien cau truy van
    $query = mysqli_query($conn, $sql);

    // Lay tung ban ghi va dua vao bien result[]
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }
    }

    foreach ($result as $key => $val) {
        $newArray[$val['id']]['id'] = $val['id'];
        $newArray[$val['id']]['name'] = $val['name'];
        $newArray[$val['id']]['id_class'] = $val['id_class'];
        $newArray[$val['id']]['sex'] = $val['sex'];
        $newArray[$val['id']]['birthday'] = $val['birthday'];
        $newArray[$val['id']]['class_name'] = $val['class_name'];
        $newArray[$val['id']]['subjects'][$counter]['subject_name'] = $val['subject_name'];
        $newArray[$val['id']]['subjects'][$counter]['score'] = $val['score'];
        $counter++;
    }

    return $newArray;
}
