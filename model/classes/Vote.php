<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.05.2019
 * Time: 2:04
 */

class Vote {
    function __construct()
    {
    }

    /*
     * User
     */
    private $responsible;

    /*
     * array of ids
     */
    private $allowedToVote;

    /*
     * array
     */
    private $nominations;

    /*
     * array
     */
    private $participants;

    public function getResponsible(){
        if(!isset($this->responsible)){
            global $db;
            $this->responsible = new User($db->Select(
                [],
                "vote_responsible"
            )->fetch()['id']);
        }
        return $this->responsible;
    }

    public function getAllowed(){
        if(!isset($this->allowedToVote)){
            global $db;
            $this->allowedToVote = $db->Select(
                [],
                "vote_electorate"
            )->fetchAll("id");
        }
        return $this->allowedToVote;
    }
}