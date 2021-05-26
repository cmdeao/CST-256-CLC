<?php

/*
 * CLC-Project-256
 * Version 0.7
 * Cameron Deao, Zachary Gardner, Mercedes Thigpen
 * 5/30/2021
 * Job History DAO performs operations for retrieving, inserting, deleting,
 * and updating information within the persistent database of the application.
 * Data is returned or results of operations are returned based on the outcome.
 */

namespace App\Services\Data;
use App\Models\JobHistory;

class JobHistoryDAO
{
    //Get all job history returns all the job history of a specific user.
    public function getAllJobHistory($userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL query and establishing result set.
        $sql = "SELECT * FROM job_history WHERE id = '$userID'";
        $result = mysqli_query($database, $sql);
        
        //Creating array for storage.
        $index = 0;
        $jobHistory = array();
        
        //Iterating through results and adding job history into the array.
        while($row = $result->fetch_assoc())
        {
            $jobHistory[$index] = array($row['job_title'], $row['company_name'], $row['start_date'],
                $row['end_date'], $row['job_location'], $row['job_description'], $row['id']);
            ++$index;
        }
        
        //Freeing results and closing connection.
        $result->free();
        mysqli_close($database);
        
        //Returing array.
        return $jobHistory;
    }
    
    //Create job history inserts passed job history in the database.
    public function createJobHistory(JobHistory $history)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values passed into method.
        $title = $history->getTitle();
        $company = $history->getCompany();
        $startDate = $history->getStartDate();
        $endDate = $history->getEndDate();
        $location = $history->getLocation();
        $description = $history->getDescription();
        $userID = $history->getUserID();
        
        //Creating SQL insert query.
        $sql = "INSERT INTO job_history (job_title, company_name, start_date, end_date,
            job_location, job_description, id) VALUES ('$title', '$company', '$startDate',
                '$endDate', '$location', '$description', '$userID')";
        
        //Executing query. Returning true if successful, else returning false.
        if(mysqli_query($database, $sql))
        {
            return true;
        }
        else
        {
            echo "Failed to create job history of " . $title . " for user " . $userID . "<br>";
            echo "Issue: " . $database->error . "<br>";
            return false;
        }
    }
    
    //Delete job history removes job history from the database based on passed parameters.
    public function deleteJobHistory($historyID, $userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Creating SQL deletion query based on history ID and user ID.
        $sql = "DELETE FROM job_history WHERE ID = '$historyID' AND user_id = '$userID'";
        
        //Executing query. Returning true if successful, else returning false.
        if($database->query($sql))
        {
            return true;
        }
        else
        {
            echo "Failed to delete job history " . $historyID . " for user " . $userID . "<br>";
            return false;
        }
    }
    
    //Update job history will update the job history of a specific user in the database.
    public function updateJobHistory(JobHistory $history, $userID)
    {
        //Establishing connection to the database.
        $link = new Database();
        $database = $link->getConnection();
        
        //Retrieving values from Job History Model.
        $title = $history->getTitle();
        $company = $history->getCompany();
        $startDate = $history->getStartDate();
        $endDate = $history->getEndDate();
        $location = $history->getLocation();
        $description = $history->getDescription();
        
        //Preparing SQL statement.
        $sql = $database->prepare("UPDATE job_history SET job_title=?, company_name=?,
            start_date=?, end_date=?, job_location=?, job_description=? WHERE id = '$userID'");

        //Binding parameters.
        $sql->bind_param("ssssss", $title, $company, $startDate, $endDate, $location,
                $description);
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

