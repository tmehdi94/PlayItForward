<?php
class Mission {

	public $mid;
	public $title;
	public $description;
	public $level;
	public $isReusable;

    public function __construct($p_missionId, $db) {
    	$mission = $db->rawQuery("SELECT m.* FROM missions m WHERE m.mid = ?", Array ($p_missionId));
        if ($db->count != 1) {
            print "Primary key error: Two missions share the same missionId";
            return;
        }
	    $this->mid = $mission[0]['mid'];
		$this->title = $mission[0]['title'];
		$this->description = $mission[0]['description'];
		$this->level = $mission[0]['level'];
		$this->isReusable = $mission[0]['isReusable'];
	}

}
?>