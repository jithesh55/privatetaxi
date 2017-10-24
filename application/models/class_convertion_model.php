<?php
class Class_convertion_model extends CI_Model {

public $var1=array("Computer Science","Mechanical","Civil","Electrical","Electronics");
public $var2=array("R","M","C","E","L");

  public function list_full_names()
  {
  		$var1=$this->var1;
  		return $var1;
  }
  public function list_short_names()
  {
  		$var2=$this->var2;
  		return $var2;
  }
  public function check_full_name($primary)
  {
  		$var1=$this->var1;
  		foreach ($var1 as $value) {
  			if($value==$primary)
  				return 1;
  		}
  		return 0;
  }
  public function check_short_name($primary)
  {
  		$var2=$this->var2;
  		foreach ($var2 as $value) {
  			if($value==$primary)
  				return 1;
  		}
  		return 0;
  }
  public function convert($primary)
  {
  	    $var1=$this->var1;
  		$var2=$this->var2;
  	if(strlen($primary)==1)
  	{
  		for($i=0 ; $var1[$i]!=NULL ; $i++)
  		{
  			if($var2[$i]==$primary)
  				return $var1[$i];
  		}
  		return NULL;
  	}
  	else
  	{
  		for($i=0 ; $var1[$i]!=NULL ; $i++)
  		{
  			if($var1[$i]==$primary)
  				return $var2[$i];
  		}
  		return NULL;
  	}
  }

  public function decode_class($pri)
  {
      $class=$pri;
      $division= explode('-', $class);
      $des=$division[1].' '.$division[0].'-'.$this->convert($division[2]).', '.$division[3].' Batch';
      $quer=$this->db->simple_query('SELECT remark FROM class_list WHERE class="'.$pri.'"');
      if($row=mysqli_fetch_array($quer))
      {
        if(!empty($row['remark']))
          $des=$des.' ('.$row['remark'].')';
      }
      return $des;
  }
  public function add_remark_to_shortened_class($class)
  {
    $des=$class;
    $quer=$this->db->simple_query('SELECT remark FROM class_list WHERE class="'.$class.'"');
      if($row=mysqli_fetch_array($quer))
      {
        if(!empty($row['remark']))
          $des=$class.' ('.$row['remark'].')';
      }
        
      return $des;
  }

  public function get_all()
  {
  	$var=$this->db->simple_query("SELECT class,remark FROM class_list");
  	$single=array();
  	while($row=mysqli_fetch_array($var))
  	{
  		$class=$row['class'];
  		$des=$this->decode_class($class);
      if(empty($row['remark']))
  		  $primitive = array('class' => $class,'edit_class' => $class , 'des' => $des);
      else
        $primitive = array('class' => $class,'edit_class' => $class.' ('.$row['remark'].')', 'des' => $des.' ('.$row['remark'].')');
  		array_push($single, $primitive);
  	}
  	return $single;

  }
  public function get_all_unhidden()
  {
    $var=$this->db->simple_query("SELECT class,remark FROM class_list WHERE hide=0");
    $single=array();
    while($row=mysqli_fetch_array($var))
    {
      $class=$row['class'];
      $des=$this->decode_class($class);
      if(empty($row['remark']))
        $primitive = array('class' => $class,'edit_class' => $class , 'des' => $des);
      else
        $primitive = array('class' => $class,'edit_class' => $class.' ('.$row['remark'].')', 'des' => $des.' ('.$row['remark'].')');
      array_push($single, $primitive);
    }
    return $single;

  }
  public function convert_all($class)
  {
      $division5=explode('-', $class);

      $course=$division5[0];
      $branch=$this->convert($division5[2]);
      $division=$division5[3];
      $res=array($course,$branch,$division);
      return $res;
  }

 }