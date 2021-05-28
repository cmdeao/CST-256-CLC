<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Education DAO performs operations for retrieving, inserting, deleting,
 * and updating information within the persistent database of the application.
 * Data is returned or results of operations are returned based on the outcome.
 */

namespace App\Services\Data;
use App\Models\EducationModel;

class EducationDAO
{
    //Get education method returns the education of a specified user.
    public function getEducation($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM education WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Checking if result set returned and rows.
        if(mysqli_num_rows($result) == 0)
        {
            //Freeing result set and closing connection.
            $result->free();
            mysqli_close($database);
            return null;
        }
        elseif(mysqli_num_rows($result) == 1)
        {
            //Fetching association of returned row. 
            $row = $result->fetch_assoc();
            //Creating new Education Model with retrieved values.
            $userEducation = new EducationModel($row['id'], $row['school'], $row['degree'],
                $row['field_of_study'], $row['start_date'], $row['end_date'], $row['grade'],
                $row['description'], $row['user_id']);
            
            //Freeing result set and closing connection.
            $result->free();
            mysqli_close($database);
            
            //Returning newly created Education Model.
            return $userEducation;
        }
    }
    
    //Create education creates an education entry for a specific user.
    public function createEducation(EducationModel $education)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values of passed Education Model object.
        $id = $education->getID();
        $school = $education->getSchool();
        $degree = $education->getDegree();
        $study = $education->getStudy();
        $startDate = $education->getStartDate();
        $endDate = $education->getEndDate();
        $grade = $education->getGrade();
        $description = $education->getDescription();
        $userID = $education->getUserID();
        
        //Creating query to insert values into education table.
        $sql = "INSERT INTO education(school, degree, field_of_study, start_date, end_date, grade, description, user_id) 
        VALUES ('$school', '$degree', '$study', '$startDate', '$endDate', '$grade', '$description', '$userID')";
        
        //Checking results of operation. Returning true or false based on the result.
        if(mysqli_query($database, $sql))
        {
            echo "Created education for " . $userID . "<br>";
            return true;
        }
        else
        {
            echo "Failed to create education for " . $userID . "<br>";
            echo "Error description: " . $database->error . "<br>";
            return false;
        }
    }
    
    //Update education updates the education of a specified user.
    public function updateEducation(EducationModel $education)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values of passed Education Model object.
        $id = $education->getID();
        $school = $education->getSchool();
        $degree = $education->getDegree();
        $study = $education->getStudy();
        $startDate = $education->getStartDate();
        $endDate = $education->getEndDate();
        $grade = $education->getGrade();
        $description = $education->getDescription();
        $userID = $education->getUserID();

        //Preparing an SQL query.
        $sql = $database->prepare("UPDATE education SET school=?, degree=?, field_of_study=?, start_date=?, 
            end_date=?, grade=?, description=? WHERE user_id='$userID'");
        //Binding the parameters.
        $sql->bind_param('sssssis', $school, $degree, $study, $startDate, $endDate, $grade, $description);
        //Executing statement.
        $sql->execute();
        
        //Returning true if operation was successful, else returning false.
        if($sql)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

