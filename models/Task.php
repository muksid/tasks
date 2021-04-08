<?php
/**
 *
 */
class Task
{
	public $id;
	public $user_name;
	public $email;
	public $task_text;
    // message string
    public $id_msg;
    public $user_name_msg;
    public $email_msg;
    public $task_text_msg;

	function __construct()
	{
		# code...
        $id=0;$user_name=$email=$task_text="";
        $id_msg=$user_name_msg=$email_msg=$task_text_msg="";
	}
}
