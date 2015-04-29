<?php
class Journal {

	public $journalId;
	public $userId;
	public $missionId;
	public $saveDate;
	public $journalTitle;
	public $journalText;

    public function __construct($p_missionId, $db) {
    	$mission = $db->rawQuery("SELECT m.* FROM missions m WHERE m.mid = ?", Array ($p_missionId));
        if ($db->count != 1) {
            print "Primary key error: Two missions share the same missionId";
            return;
        }
	    $this->journalId = $mission[0]['journal_id'];
		$this->userId = $mission[0]['uid'];
		$this->missionId = $mission[0]['mid'];
		$this->saveDate = $mission[0]['saveDate'];
		$this->journalTitle = $mission[0]['journalTitle'];
		$this->journalText = $mission[0]['journalText'];
	}

}
?>