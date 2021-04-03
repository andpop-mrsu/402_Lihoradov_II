c<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\StudentsList;
use App\Student;

class StudentsListTest extends TestCase
{
    public function testAddAndCount()
    {
        $student = new Student();
        $studentsList = new StudentsList();
        $studentsList -> add($student);
        $this -> assertSame(1, $studentsList -> count());
    }

    public function testGet()
    {
        $student = new Student();
        $studentsList = new StudentsList();
        $student -> setName("Иван") -> setLastName("Лихорадов") -> setFaculty("ФМиИТ") -> setCourse(4) -> setGroup(402);
        $studentsList -> add($student);
        $this -> assertInstanceOf(Student::class, $studentsList -> get(1));
    }

    public function testStore()
    {
        $student = new Student();
        $studentsList = new StudentsList();
        $student -> setName("Иван") -> setLastName("Лихорадов") -> setFaculty("ФМиИТ")-> setCourse(4) -> setGroup(402);
        $studentsList -> add($student);
        $this -> assertSame(null, $studentsList -> store("output"));
    }

    public function testLoad()
    {
        $studentsList = new StudentsList();
        $studentsList -> load("output");
        $this -> assertSame(1, $studentsList -> count());
        $this -> assertInstanceOf(Student::class, $studentsList -> get(1));
        $this -> assertSame("Файл fileName не существует!", $studentsList -> load("fileName"));
    }

    public function testCurrentAndKey()
    {
        $student1 = new Student();
        $student2 = new Student();
        $student3 = new Student();
        $studentsList = new StudentsList();
        $student1 -> setName("Иван") -> setLastName("Лихорадов") -> setFaculty("ФМиИТ")-> setCourse(4) -> setGroup(402);
        $student2 -> setName("Иван") -> setLastName("Иванов") -> setFaculty("ИСИ") -> setCourse(2) -> setGroup(201);
        $student3 -> setName("Пётр") -> setLastName("Голубев") -> setFaculty("ИНК") -> setCourse(3) -> setGroup(303);
        $studentsList -> add($student1);
        $studentsList -> add($student2);
        $studentsList -> add($student3);

        $this -> assertSame("Id: 6" . "\n" .
        "Фамилия: Лихорадов" . "\n" .
        "Имя: Иван" . "\n" .
        "Факультет: ФМиИТ" . "\n" .
        "Курс: 4" . "\n" .
        "Группа: 402", $studentsList -> current() -> __toString());
        $this -> assertSame(6, $studentsList -> key());
        return $studentsList;
    }
    /**
     * @depends testCurrentAndKey
     */

    public function testNext(StudentsList $studentsList)
    {
        $studentsList -> next();
        $this -> assertSame("Id: 7" . "\n" .
        "Фамилия: Иванов" . "\n" .
        "Имя: Иван" . "\n" .
        "Факультет: ИСИ" . "\n" .
        "Курс: 2" . "\n" .
        "Группа: 201", $studentsList -> current() -> __toString());
        $studentsList -> next();
        $this -> assertSame("Id: 8" . "\n" .
        "Фамилия: Голубев" . "\n" .
        "Имя: Пётр" . "\n" .
        "Факультет: ИНК" . "\n" .
        "Курс: 3" . "\n" .
        "Группа: 303", $studentsList -> current() -> __toString());

        return $studentsList;
    }

    /**
     * @depends testNext
     */

    public function testValidAndRewind(StudentsList $studentsList)
    {
        $studentsList -> next();
        $this -> assertSame(false, $studentsList -> valid());
        $studentsList -> rewind();
        $this -> assertSame(true, $studentsList -> valid());
        $this -> assertSame("Id: 6" . "\n" .
        "Фамилия: Лихорадов" . "\n" .
        "Имя: Иван" . "\n" .
        "Факультет: ФМиИТ" . "\n" .
        "Курс: 4" . "\n" .
        "Группа: 402", $studentsList -> current() -> __toString());
    }
}
