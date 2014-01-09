<?php

class Attachment extends AttachmentDB
{
	public function findByProjectId($studyId, $projectId)
    {
    	return parent::findAllByAttributes(array('studyId'=>$studyId, 'projectId'=>$projectId));
	}
}