<?php
namespace App\Services\Data;
use App\Models\EducationModel;

class EducationDAO
{
    public function getEducation($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM education WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        if(mysqli_num_rows($result) == 0)
        {
            $result->free();
            mysqli_close($database);
        }
        elseif(mysqli_num_rows($result) == 1)
        {
            $row = $result->fetch_assoc();
            $userEducation = new EducationModel($row['id'], $row['school'], $row['degree'],
                $row['field_of_study'], $row['start_date'], $row['end_date'], $row['grade'],
                $row['description'], $row['user_id']);
            
            $result->free();
            mysqli_close($database);
            
            return $userEducation;
        }
    }
    
    public function createEducation(EducationModel $education)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $id = $education->getID();
        $school = $education->getSchool();
        $degree = $education->getDegree();
        $study = $education->getStudy();
        $startDate = $education->getStartDate();
        $endDate = $education->getEndDate();
        $grade = $education->getGrade();
        $description = $education->getDescription();
        $userID = $education->getUserID();
        
        $sql = "INSERT INTO education(school, degree, field_of_study, start_date, end_date, grade, description, user_id) 
        VALUES ('$school', '$degree', '$study', '$startDate', '$endDate', '$grade', '$description', '$userID')";
        
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
    
    public function updateEducation(EducationModel $education)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $id = $education->getID();
        $school = $education->getSchool();
        $degree = $education->getDegree();
        $study = $education->getStudy();
        $startDate = $education->getStartDate();
        $endDate = $education->getEndDate();
        $grade = $education->getGrade();
        $description = $education->getDescription();
        $userID = $education->getUserID();

        $sql = $database->prepare("UPDATE education SET school=?, degree=?, field_of_study=?, start_date=?, 
            end_date=?, grade=?, description=? WHERE user_id='$userID'");
        $sql->bind_param('sssssis', $school, $degree, $study, $startDate, $endDate, $grade, $description);
        $sql->execute();
        
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

