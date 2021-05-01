<?php
namespace App\Services\Data;
use App\Models\JobHistory;

class JobHistoryDAO
{
    public function getAllJobHistory($userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "SELECT * FROM job_history WHERE user_id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        $index = 0;
        $jobHistory = array();
        
        while($row = $result->fetch_assoc())
        {
            $jobHistory[$index] = array($row['job_title'], $row['company_name'], $row['start_date'],
                $row['end_date'], $row['job_location'], $row['job_description'], $row['user_id']);
            ++$index;
        }
        
        $result->free();
        mysqli_close($database);
        
        return $jobHistory;
    }
    
    public function createJobHistory(JobHistory $history)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $title = $history->getTitle();
        $company = $history->getCompany();
        $startDate = $history->getStartDate();
        $endDate = $history->getEndDate();
        $location = $history->getLocation();
        $description = $history->getDescription();
        $userID = $history->getUserID();
        
        $sql = "INSERT INTO job_history (job_title, company_name, start_date, end_date,
            job_location, job_description, user_id) VALUES ('$title', '$company', '$startDate',
                '$endDate', '$location', '$description', '$userID')";
        
        if(mysqli_query($database, $sql))
        {
            echo "Created job history of " . $title . " for user " . $userID . "<br>";
            return true;
        }
        else
        {
            echo "Failed to create job history of " . $title . " for user " . $userID . "<br>";
            return false;
        }
    }
    
    public function deleteJobHistory($historyID, $userID)
    {
        $link = new Database();
        $database = $link->getConnection();
        
        $sql = "DELETE FROM job_history WHERE ID = '$historyID' AND user_id = '$userID'";
        
        if($database->query($sql))
        {
            echo "Deleted job history " . $historyID . " for user " . $userID . "<br>";
            return true;
        }
        else
        {
            echo "Failed to delete job history " . $historyID . " for user " . $userID . "<br>";
            return false;
        }
    }
}

