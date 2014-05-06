<?php

//body parts!
class body extends thing
{
  public $health=50;
  public $name="body";
}
class spine extends body
{
  public $name="spine";
}
class neck extends body
{
  public $name="neck";
}
class head extends neck
{
  public $name="head";
}
class skin extends body
{
  public $name="skin";
}
class torso extends body
{
  public $name="torso";
}
class stomach extends torso
{
  public $name="stomach";
}
  class pelvis extends stomach //sorry this section is rather long, I could include it from a separate file later on
{
  public $name="pelvis";
}
class bladder extends stomach
{
  public $name="bladder";
}
class chest extends torso
{
  public $name="chest";
}
class heart extends chest
{
  public $rhythmspeed=90.0;
  public $name="heart"; //thought for later, if your heart beats too fast it's usually because you are afraid
}
class lung extends chest
{
  public $name="lung";
}
class leg extends body
{
  public $name="leg";
}
class back extends spine
{
  public $name="back";
}
class gluteus extends back
{
  public $name="gluteus";
}
class foot extends leg
{
  public $name="foot";
}
class arm extends body
{
  public $name="arm";
}
class hand extends arm
{
  public $name="hand";
}
class brain extends head
{
  public $name="brain";
}
 ?>
