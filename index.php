<?php
  
class timeofday
{
  public $dayornight = "day";
  public function daynight($person)
  {
    $rand=rand(0,1);
    if($rand==0){
      $dayornight = "night";
    }
        else {
          $dayornight = "day";
        }
    if($dayornight=="day"){
      $person->happiness+=2;
      $person->alertness+=2;
      return "happiness,2 alertness,2|time";
    }
    else
    {
      $person->happiness-=2;
      $person->alertness-=1;
      $person->vision=false;
      $person->fear+=1;
      return "fear,1|time";
    }
  }
}
class emotionsanduniversals extends thought
  {
  public $fear="lack of knowledge";
  public $nofear="shining light";
  public $health="wellness";
  public $nohealth="departed";
  public $dignity="overcoming things";
  public $nodignity="being small";
  public $happiness="being upbeat";
  public $nohappiness="optimism";
  public $disgust="loving soul";
  public $nodisgust="magnetism";
  public $intrigue="involvement";
    //I should start making associations two-way, forward and backward, without creating infinite loops.
//For instance, I should be able to have a thought instance that uses its knowledge function
    //to keep track of WHY we get scared, when it happens, what functions cause it, and therefore, every
//function that increases modeled fear, happiness, or other emotions must return the difference generated
    //for those values.
    
    public function getemotionsnoun($person){ /*Remember to call this function only indirectly
                                          through the function popfirstcheckemotions, in
                                          order to avoid an infinite loop.
                                          fear,health,dignity,happiness,disgust,intrigue*/
    $emotionarray=array("fear"=>$person->fear,"health"=>$person->health,"dignity"=>$person->dignity,"happiness"=>$person->happiness,"disgust"=>$person->disgust,"intrigue"=>$person->intrigue);
    foreach($emotionarray as $key=>$value){
      if($key=="fear" && $value>50)
      {
        return $this->fear;
      }
      else if($key=="fear" && $value<50)
      {
        return $this->nofear;  //More variety and randomness to be added later
      }
      else if($key=="health" && $value>50)
      {
        return $this->health;
      }
      else if($key=="health" && $value<50)
      {
        return $this->nohealth;
      }
      else if($key=="dignity" && $value>50)
      {
        return $this->dignity;
      }
      else if($key=="dignity" && $value<50)
      {
        return $this->nodignity;
      }
      else if($key==happiness && $value>50)
      {
        return $this->happiness;
      }
      else if($key=="happiness" && $value<50)
      {
        return $this->nohappiness;
      }
      else if($key=="disgust" && $value>50)
      {
        return $this->disgust;
      }
      else if($key=="disgust" && $value<50)
      {
        return $this->nodisgust;
      }
      else if($key=="intrigue" && $value>50){
        return $this->intrigue;
      }
      else {
        $rand=rand(0,5);
        if($rand==0){
          return "boredom";
        }
        else if($rand==1){
          return "tediousness";
        }
        else if($rand==2){
          return "disinterest";
        }
        else if($rand==3){
          return "insanity";
        }
        else if($rand==4){
          return "peculiarity";
        }
        else {
          return "!";
        }
      }  
    } 
  }
}
class thing
{
  //the following 6 params are always displayed by a thing
   public $length;
   public $width;
   public $height;
   public $weight;
   public $name;
   public $color;
   public $time = time;
   public $audibility = true;
   public $visibility = true;
   public $positionlocalx = 0.0;
   public $positionlocaly = 0.0;
   public $positionlocalz = 0.0;
   public $badorgood = 50;
   public function iterate()
   {
      $myiteration = array();
      foreach($this as $value)
      {
         array_push($myiteration, $value);
      }
      return $myiteration;
   }
   public function __get($attribute)
   {
      return $this->attribute;
   }
   public function __set($attribute, $value)
   {
     //limit
      if(gettype($this->attribute)=="integer")
      {
        if($value<0)
        {
          $value=0;
        }
        if($value>100)
        {
          $value=100;
        }
        $this->attribute=$value;
      }
      $this->attribute=$value;
   }
  public function inside($insideobject)//add what it's inside of
    {
      $insideobject->visibility=false;
    }
    public function outside($outsideobject)
    {
      //this all just means the outside-object is at a position over half the length of the current object away, horizontally
if($outsideobject != $this && $outsideobject->positionlocalx>$this->positionlocalx+$this->length/2 || $outsideobject->positionlocalx<$this->positionlocalx+$this->length/2 && $outsideobject->positionlocaly>$this->positionlocaly+$this->width/2 || 

$outsideobject->positionlocaly<$this->positionlocaly+$this->width/2)
      {
        $outsideobject->visibility=true;
      }
    }
  public function burnt()
  {
    $color="black";
  }
}
    
include "bodyparts.php";
  
class plant extends thing
{
  public $color = "green";
  public function vegetable()
  {
    //put something here
  }
}
class food extends thing
{
  public $taste="neutral";
  public function burnt()
  {
    $color="black";
    $taste="bitter";
  }
  public function __construct($thistaste){
    $this->taste=$thistaste;
  }
}
  //the person instantiated later will have a name of "he/she" assigned to it
  //if the bot stumbles across it in the database
class animal extends thing
{
  public $life = true;
  public $age=10.0;
  public $gender;
  public $health=50;
  public $dignity=40;
  public $happiness = 50;
  public $disgust = 50;
  public $intrigue = 50;
  public $fear = 50;
  public $alertness = 50;
  public $taste=true;
  public function gender(){
    $genderrand=rand(0,1);
    if($genderrand==0){
      $gender=="male";
    }
    else{
      $gender=="female";
    }  
  }
  public function has($arrobject, $mode, $bool)//determines has or hasn't for non-parts
  {
    //I'll use the mode variable later, as in for pets' toys.
    //For now we don't use it.
    //
    //if you're missing a crucial part, $life value switches to false
    $crucialparts = array("head","stomach","heart","lung","bladder","neck","spine");
    $i=0;
    foreach($arrobject as $value) //possibly make this clearer, will the "objects" be objects or strings?
      foreach($crucialparts as $crucialvalue)
       {
        {
          if($value->name==$crucialvalue)
          {
            $i=1;
            if($value->name!="skin")
            {
              $this->inside($value);
            }
           }
                //I just thought of another scenario where we can use the "inside" function.
                //It might be stretching it too far and risking infinite loop to place thought objects.
         }            
        }
      if($i==0) {
        $this->life=false;
        return $this->outside(array_rand($crucialparts,1));
      }
      else
      {
        return $this->inside(array_rand($crucialparts,1));
      }
  }
  public function meat()
  {
    $spine=new spine();
    $heart=new heart();
    $skin=new skin();
    $fragmentofbodyarray = array(new spine(),new skin());
    $this->has($fragmentofbodyarray, "part", true);
    $heart->positionlocalx=$this->positionlocalx+9.5; //an estimation of how far the dinner table could be from the turkey...
    $food=new food("neutral");
    $food->taste="salty food";
    $food->name="meat";
    return $food;
  }
  public function taste($food)
  {
    //verb returned without punctuation and with/without direct object
    if($this->taste==true){
      if($food->taste=="bitter" || $food->taste=="sour")
      {
        $this->disgust+=1;
        return "disgust,1|taste|bitter"; /*Note to self: when these are returned,
                                                    the word such as "bitter"
                                                    will be compared to these
                                                    strings; and then create
                                                    a metaphor with perhaps enen an action
                                                    */
      }
      else if($food->taste=="fatty"){
        $this->happiness+=1;
        return "happiness,1|taste|fatty";
      }
      else if($food->taste=="sweet"){
        $this->happiness+=1;
        $this->disgust-=1;
        return "happiness,1 disgust,-1|taste|sweet";
      }
      else if($food->taste=="salty"){
        $this->happiness+=1;
        $this->intrigue+=1;
        return "happiness,1 intrigue,1|taste|salty";
      }
      else if($food->taste=="neutral"){
        $this->intrigue-=1;
        return "intrigue,-1|taste|tasteless";
      }
    }
    else
    {
      return "intrigue,0|ate";
    }
  }
  public function burnt()
  {
    $color="black";
    $health-=6;
    $randomstring=rand(0,3);
    $string = "health,-6|".$this->name." is ";
    if($randomstring==0){
      $string.="burned";
    }
    else if($randomstring==1){
      $string.="hot";
    }
    else if($randomstring==2){
      $string.="sizzling";
    }
    else
    {
      $string.="boiling";
    }
    return $string;
  }
}
  
class sound {
  public $volume=50;
  public $length=10.0; /*10 seconds initially, taking tradition from Second Life.
                    Calling it length instead of duration for consistency.*/
  
}
class song extends sound {
  public $rhythmspeed=50; //let's put this one on the heart class later
}

class person extends animal
{
  //if these values aren't null, we can begin making numerical fraction comparisons
  //for them once the object is instantiated
  //
  //position and measurements will be in feet, scales between 0 and 10.
  //Differentiate them by making measurements doubles and scales whole numbers
  public $width = 2.3;
  public $height = 5.2;
  public $age = 50; //init. What the heck.
  public $responsibility = 50;
  public $dignity = 50;
  public $country = "United States";
  public $loneliness = 50; //my first scale-range based number; initialize it at 50 to be in-between 0 and 100
  public $privacy = 50;
  public $vision = true;
  public $hearing = true;
  public $touch = true;
  public $balance = true;
  public $acceleration = true;
  public $taste = true;
  public $color = "beautiful";
  //body
  public $body;
  public $head;
  public $skin;
  public $stomach;
  public $heart;
  public $leftlung;
  public $rightlung;
  public $bladder;
  public $neck;
  public $leftfoot;
  public $righttfoot;
  public $chest;
  public $leftarm;
  public $rightarm;
  public $lefthand;
  public $righthand;
  public $brain;
  public $spine;
  public $back;
  public $gluteus;
  public $torso;
  public $pelvis;
  
  /*
  public $length;
   public $width;
   public $height;
   public $name;
   public $color;
   public $time = time;
   public $audibility = true;
   public $visibility = true;
   public $positionlocalx = 0.0;
   public $positionlocaly = 0.0;
   public $positionlocalz = 0.0;
   public $badorgood = 50;
  */
  
  public function __construct($list)
  {
    $personalnamesarr=array

("a an","a lady","the mailman","an ant","a girl","a bug","juice","milk","cheese","someone","him", 
"her","that guy","a bird","the Lord","a worm","a bug","God","my lover","the Devil","most of you","a good person","most people",
"cheese","Greg","Jenn","Bob","Joy","Daddy","Momma","Rachel","Peter","friends","enemies","Robin","Diana","Phil","a pain","Doug",
"that guy","Jesus","men","Helen","Fred","Karen","grass","Ben","Shane","Erin","Mom","Papa","my dad","my mom","shake","bumblebee",
"Kisha","Anisha","Isaac","Thomas","a plump tomato","Gordon","a child","Buddha","Krishna","the President","the Queen","the King",
"Edward","my dog","my cat","my hamster","my pet snake","my tarantula","your face","your backyard","your hamster","your stomach",
"your life","the Prince","the Princess","a goblin","a coward");
    $rand=rand(0,count($personalnamesarr)-1);
    $this->name=$personalnamesarr[$rand];
    $agerandperson = rand(0,90)+0.5;
    $this->age=$agerandperson;
    /*
    $this->body)->color=$this->color;
    $this->body->name=$this->name."'s body";
    $this->head->name=$this->name."'s head";
    $this->head->color=$this->color;
    $this->skin->name=$this->name."'s skin";
    $this->skin->color=$this->color;
    $this->stomach->name=$this->name."'s stomach";
    $this->stomach->color="pink";
    $this->heart->name=$this->name."'s heart";
    $this->heart->color="red";
    $this->leftlung->name=$this->name."'s left lung";
    $this->leftlung->color="beige";
    $this->rightlung->name=$this->name."'s right lung";
    $this->rightlung->color="beige";
    $this->bladder->name=$this->name."'s bladder";
    $this->bladder->color="beige";
    $this->neck->name=$this->name."'s neck";
    $this->neck->color=$this->color;
    $this->leftfoot->name=$this->name."'s left foot";
    $this->leftfoot->color=$this->color;
    $this->pelvis->name=$this->name."'s pelvis";
    $this->pelvis->color=$this->color;
    $this->rightfoot->name=$this->name."'s right foot";
    $this->rightfoot->color=$this->color;
    $this->chest->name=$this->name."'s chest";
    $this->chest->color=$this->color;
    $this->leftarm->name=$this->name."'s left arm";
    $this->leftarm->color=$this->color;
    $this->rightarm->name=$this->name."'s right arm";
    $this->rightarm->color=$this->color;
    $this->lefthand->name=$this->name."'s left hand";
    $this->lefthand->color=$this->color;
    $this->righthand->name=$this->name."'s right hand";
    $this->righthand->color=$this->color;
    $this->brain->name=$this->name."'s brain";
    $this->brain->color="pink";
    $this->spine->name=$this->name."'s spine";
    $this->spine->color="white";
    $this->back->name=$this->name."'s back";
    $this->back->color=$this->color;
    $this->gluteus->name=$this->name."'s gluteus";
    $this->gluteus->color=$this->color;
    $this->torso->name=$this->name."'s torso";
    */
    if($this->age<13.0){
      $this->height=0.8*$this->age+2.167;
      $this->weight=8.4*$this->age+12.0;
    }
    else if($this->age>13.0&&$this->age<20.0){
      if($this->gender=="female"){
        $this->height=sqrt($this->age-13)/2+5.17;
        $this->weight=sqrt(2*$this->age-26)+105.0;
      }
      else{
        $this->height=sqrt(3*$this->age-39)/2.5+5.17;
        $this->weight=sqrt(5*$this->age-65)+105;
      }
    }
    else if($this->age>20&&$this->age<=65){
      $randomheightness=rand(38,78);
      $this->height=$randomheightness/1.02;
      $this->weight=rand(80,240);
    }
    else if($this->age>65){
      $randomheightness=rand(32,72);
      $this->height=$randomheightness/1.02;
      $this->weight=rand(80,240);
    }
    $body->positionlocaly=$this->positionlocaly;
    $body->positionlocalx=$this->positionlocalx;
    $body->positionlocalz=$this->positionlocalz;
    $spine->positionlocaly=$body->positionlocaly;
    $spine->positionlocalx=$body->positionlocalx;
    $spine->positionlocalz=$body->positionlocalz;
    $spine->height=$this->height*161.0/524.9;
    $spine->width=$this->width/9.8;
    $head->positionlocalz=$spine->positionlocalz+$spine->height/1.9;
    $list=explode("|",$list);
    foreach($list as $value){
      if(strpos($value, ",")!==false){
        $valuelist = explode(",",$value);  //3params delimited by commas
        $arrayiter=array

("body","head","skin","stomach","heart","leftlung","rightlung","bladder","neck","leftfoot","rightfoot","chest","leftarm","rightarm

","lefthand","righthand","brain","spine","back","gluteus","torso","pelvis");
        foreach($arrayiter as $arrayval){
          if (strpos($arrayval, $valuelist[0])!==false){  /*If it's a part of the body                                             

                                                    and its name is found in the input list*/
            if($valuelist[1]=="health"){
              $bodypartargs=$valuelist[2].",0,0,0,flesh";
            }
            else if($valuelist[1]=="length"){
              $bodypartargs="0,".$valuelist[2].",0,0,flesh";
            }
            else if($valuelist[1]=="width"){
              $bodypartargs="0,0,".$valuelist[2].",0,flesh";
            }
            else if($valuelist[1]=="height"){
              $bodypartargs="0,0,0,".$valuelist[2].",flesh";
            }
            else if($valuelist[1]=="color"){
              $bodypartargs="0,0,0,0,".$valuelist[2];
              $this->body = new body();
            }
            else {
              $bodypartargs="0,0,0,0,flesh";
            } 
          }
          else {
            $bodypartargs="0,0,0,0,flesh";
          }
    $this->head = new head($bodypartargs);
    $this->skin = new skin($bodypartargs);
    $this->stomach = new stomach($bodypartargs);
    $this->heart = new heart($bodypartargs);
    $this->leftlung = new lung($bodypartargs);
    $this->rightlung = new lung($bodypartargs);
    $this->bladder = new bladder($bodypartargs);
    $this->neck = new neck($bodypartargs);
    $this->leftfoot = new foot($bodypartargs);
    $this->rightfoot = new foot($bodypartargs);
    $this->chest = new chest($bodypartargs);
    $this->leftarm = new arm($bodypartargs);
    $this->rightarm = new arm($bodypartargs);
    $this->lefthand = new hand($bodypartargs);
    $this->righthand = new hand($bodypartargs);
    $this->brain = new brain($bodypartargs);
    $this->spine = new spine($bodypartargs);
    $this->back = new back($bodypartargs);
    $this->gluteus = new gluteus($bodypartargs);
    $this->torso = new torso($bodypartargs);
    $this->pelvis = new pelvis($bodypartargs);
          }
        }
      }
    }
  
  //$arrobject is an array
  public function see($object)
  {
    if($this->vision==true && $object->visibility==true)
    { 
      if(get_class($object)=="animal"){
        if($object->taste($this->meat())){
          $this->fear+=5;
          return "fear,5|see|".$object->color."|".$object->height." feet long|".$object->width." feet wide|".$object->height." 

feet tall|".$object->positionlocalx." feet to the left|".$object->positionlocaly." feet towards me|"." floating ".$object->positionlocalz." feet above me.";
          }
      }
      else if(is_subclass_of($object, 'body')){ //I can after this make functions outside of the classes to receive information
        if($object->health<50){
          $this->fear+=3;
          return "fear,3|see|".$object->color."|".$object->height." feet long|".$object->width." feet wide|".$object->height." 

feet tall|".$object->positionlocalx." feet to the left|".$object->positionlocaly." feet towards me|"." floating ".$object->positionlocalz." feet above me.";

        }
        else if($object->health>50){
          $this->fear-=4;
          return "fear,-4|see|".$object->color."|".$object->height." feet long|".$object->width." feet wide|".$object->height." 

feet tall|".$object->positionlocalx." feet to the left|".$object->positionlocaly." feet towards me|"." floating ".$object->positionlocalz." feet above me.";

        }
      }
      return "intrigue,0|see|".$object->color."|".$object->height." feet long|".$object->width." feet wide|".$object->height." 

feet tall|".$object->positionlocalx." feet to the left|".$object->positionlocaly." feet towards me|"." floating ".$object->positionlocalz." feet above me.";
    }
    else if($this->vision==true && $object->visibility==false && $object->badorgood<50){
      $this->fear+=2;
      return "intrigue,0|seenothing";
    }
    else
    {
      $this->hear($object);
      return "intrigue,0|seenothing";
    }
  }
  public function hear($object)
  {
    if($this->hearing==true && $object->audibility=true){
      $song = new sound();//note to self: do those parentheses give option for constructor parameters? 
      $this->intrigue+=2;
      return "intrigue,2|hear";
    }
    else
    {
      $this->touch($object);
      return "intrigue,0|hearnothing";
    }
  }
  public function touch($object)
  {
    return "intrigue,0|touch|".$object->length." feet long|".$object->width." feet wide|".$object->height." feet high";
  }
    public function inside($insideobject)
    {
      $insideobject->visibility=false;
      $this->privacy+=1;
      return "privacy,1|inside";
    }
    public function outside($outsideobject)
    {
      //this all just means the outside-object is at a position over half the length of the current object away, horizontally
if($outsideobject != $this && $outsideobject->positionlocalx>$this->positionlocalx+$this->length/2 || $outsideobject->positionlocalx<$this->positionlocalx+$this->length/2 && $outsideobject->positionlocaly>$this->positionlocaly+$this->width/2 || 

$outsideobject->positionlocaly<$this->positionlocaly+$this->width/2)
      {
        $outsideobject->visibility=true;
        $this->privacy-=1;
        return "privacy,-1|outside";
      }
    }
  public function age()
  {
    if($this->age>124.0)
    {
      $this->life=false;
      $this->time<time()-3786912000.0;
    }
    else if($this->age<0.75)
    {
      $this->life=false;
      $this->time>time()+23668200.0;
    }
    else if($this->age<=124.0 && $this->age>=65)
    {
      if($country="United States"){
        $dignity-=1;
      return "dignity,-1|age";
      }
    }
    return "intrigue,0|age";
  }
  public function has($arrobject, $mode, $bool)//determines has or hasn't for non-parts
  {
    if($mode == "part")
    {
      $crucialparts = array("head","stomach","heart","lung","bladder","neck");
      $i=0;
      foreach($arrobject as $value) //possibly make this clearer, will the "objects" be objects or strings?
          foreach($crucialparts as $crucialvalue)
            {
              {
                if($value->name==$crucialvalue)
                {
                  $i=1;
                  if($value->name!="skin")
                  {
                    $this->inside($value);
                  }
                }
                //I just thought of another scenario where we can use the "inside" function.
                //It might be stretching it too far and risking infinite loop to place thought objects.
              }            
            }
      if($i==0) {
        $this->life=false;
        return $this->outside(array_rand($crucialparts,1));
      }
      else
      {
        return $this->inside(array_rand($crucialparts,1));
      }
      /*
      If you have a part, it's inside you, if it's name isn't "skin"
      so then you would go to the "inside" function. make sure not to
      create an infinite loop!
      */
    }
    else if($mode == "owner_of_animal")
    {
      if($bool==false){
        $this->loneliness+=2;
        $this->responsibility-=1;
        return "loneliness,2 responsibility,-1|has";
      }
      else
      {
        $this->loneliness-=4;
        $this->responsibility+=2;
        $this->happiness+=1;
        return "loneliness,-4 responsibility,2 happiness,1|has";
      }
    }
    else// if($mode == "owner_of_thing")
    {
      $this->responsibility+=1;
      return "responsibility,1|has";
    }
    //this function takes only objects with the above 6 params.
  //other stuff won't work
  }
}
  
  //Note to self: introduce my botty later to the concept of night, invisible thing that is on the "outside"
//this will faciliate some universal concept mechanisms, not just associations we make to them
class thought
{
  public $badorgood = 50;
  public function __get($attribute)
  {
     return $this->attribute;
  }
  public function __set($attribute, $value)
   {
     //limit
      if(gettype($this->attribute)=="integer")
      {
        if($value<0)
        {
          $value=0;
        }
        if($value>100)
        {
          $value=100;
        }
        $this->attribute=$value;
      }
      $this->attribute=$value;
   }
   public function knowledge($person, $object)
  {
    $person->iterate();
    $person->see($object);
  }
  public function metaphorobjandreturn(){/*Where does the parameter here come from? Work on sentence*/
  }
  public function metaphorforobjects($object1,$object2) /*Assignment of object meaning to an object.
This type of function can also be used as
                                                         as the result of a conditional*/
  {
           //if($param1->length == $param2->length)
      $par1 = $object1->iterate();
      $par2 = $object2->iterate();
      foreach($par1 as $value1)
      {
        foreach($par2 as $value2)
        {
           if($value1 == $value2)
           {
           $t = "metaphor|".$object1."|".$object2;
           return $t;
           }
        }
      }
  }
  public function metaphorsecondlife() 
  {   
    $fear = false;
    $monster = new animal();
    $monster->name="monster";
    $monster->height=19.0;
    $monster->length=14.4;
    $monster->width=14.4;
    $monster->color="red";
    $mouse = new animal();
    $mouse->height=0.12;
    $mouse->width=0.12;
    $mouse->color="gray";
    $footballfield = new thing();
    $footballfield->length=360.0;
    $footballfield->width=160.0;
    $footballfield->height=0.1;
    $footballfield->color="green";
    $footballfield->name="football field";
    $tree3=new plant();
    $tree3->name="tree";
    $tree3->color="green";
    $tree3->width=9.0;
    $tree3->height=35.4;
    $tree3->length=9.0;
    $snot=new thing();
    $snot->name="snot";
    $snot->length=0.03;
    $snot->width=0.03;
    $snot->height=0.03;
    $snot->color="green";
    $alien=new animal();
    $alien->name="alien";
    $alien->height=5.0;
    $alien->width=2.2;
    $alien->length=2.2;
    $alien->color="green";
    $blackwidow=new animal();
    $blackwidow->name="black widow spider";
    $blackwidow->length=0.08;
    $blackwidow->width=0.08;
    $blackwidow->width=0.04;
    $blackwidow->color="black";
    $pencil=new thing();
    $pencil->width=0.09;
    $pencil->length=0.65;
    $pencil->height=0.09;
    $pencil->name="pencil";
    $pencil->color="orange";
    $door=new thing();
    $door->name="door";
    $door->width=0.2;
    $door->height=7.6;
    $door->length=3.2;
    $externaldrive=new thing();
    $externaldrive->width=0.3;
    $externaldrive->height=0.05;
    $externaldrive->length=0.4;
    $externaldrive->name="external hard drive";
    $externaldrive->color="black";
    $heatingvent=new thing();
    $heatingvent->name="heating vent";
    $heatingvent->length=1.1;
    $heatingvent->height=0.9;
    $heatingvent->width=0.08;
    $bear=new animal();
    $bear->name="bear";
    $bear->color="brown";
    $bear->height=6.2;
    $bear->width=5.6;
    $bear->length=7.5;
    $earth=new thing();
    $earth->name="Earth";
    $earth->width=41851443.0;
    $earth->length=41851443.0;
    $earth->height=41717290.0;
    $earth->color="blue";
    $table=new thing();
    $table->name="table";
    $table->width=5.6;
    $table->length=5.6;
    $table->height=5.3;
    $table->color="brown";
    $paper=new thing();
    $paper->name="paper";
    $paper->color="white";
    $paper->length=0.917;
    $paper->width=0.708;
    $paper->height=0.002;
    $powercord=new thing();
    $powercord->name="power cord";
    $powercord->length=4.6;
    $powercord->width=0.05;
    $powercord->height=0.05;
    $powercord->color="white";
    $egg=new thing();
    $egg->name="egg";
    $egg->width=0.21;
    $egg->height=0.27;
    $egg->length=0.21;
    $egg->color="white";
    $lamb=new animal();
    $lamb->name="lamb";
    $lamb->color="white";
    $lamb->length=4.0;
    $lamb->height=3.8;
    $lamb->width=2.7;
    $goat=new animal();
    $goat->name="goat";
    $goat->length=4.9;
    $goat->height=4.2;
    $goat->width=3.3;
    $goat->color="white";
    $parakeet=new animal();
    $parakeet->name="parakeet";
    $parakeet->height=0.3;
    $parakeet->width=0.15;
    $parakeet->length=0.19;
    $parakeet->color="green";
    $bat=new animal();
    $bat->name="bat";
    $bat->width=0.7;
    $bat->heigiht=0.8;
    $bat->length=0.7;
    $bat->color="black";
    
    $arrayanimals=array($monster,$mouse,$alien,$blackwidow,$bear,$lamb,$goat,$bat);
    $arraythings=array($footballfield,$tree3,$snot,$pencil,$door,$table,$paper,$heatingvent,$powercord,$egg);
    
    
    foreach($arraythings as $val){
      foreach($arraythings as $val2){
        if($val1->name!=$val2->name){
          if($val1->width>$val2->width*6){
            return "I may be a ".$val2->name." but I'm not a ".$val1->name;
          }
          else if($val1->height>$val2->width*80){
            
            return "I feel ".$val2->color.".";
          }
          else if($val1->length>$val2->length*92){
            return "No.";
          }
          else
          {
            return "I like ".$val1->color." and ".$val2->color." biscuits.";
          }
        }
        else return "Ok.";
      }
    }
  }
   //Make one function to return everything before the first "|", and another for all after.
 
        //Use this and the next function called in sequence in a separate, third function
  //this function returns adverbs
  public function checksecondparamadverb($returnedvalue)
  {
    $bar=explode("|",$returnedvalue);
    //I can determine how many return variables remain by checking the second value,
    foreach ($bar as $value){    
      if($value=="time")
      {
        return "when";
      } 
      else if($value=="taste"){
        $rand=rand(0,3);
        if($rand==0){
          return "hungry";
        }
        else if($rand==1){
          return "been craving";
        }
        else if($rand==2){
          return "desiring love";
        }
        else {
          return "thirsty";
        }
      }
      else if($value=="see"){
        $array=array("visual","perceptive","detail-oriented","visual-learning","intuitive");
        return array_rand($array,1);
      }
      else if ($value=="seenothing"){
        $array=array("faintly","darkly","dimly","blindly");
        return array_rand($array,1);
      }
      else if ($value=="hear"){
        $array=array("musically","symphonic","in tune","audibly");
        return array_rand($array,1);
      }
      else if ($value=="hearnothing"){
        $array=array("faintly","dimly","quietly","hearing nothing","not hearing at all");
        return array_rand($array,1);
      }
      else if ($value=="inside"){
        return "withdrawn";
      }
      else if ($value=="outside"){
        return "on the outside";
      }
      else if ($value=="age"){
        return "long ago";
      }
      else {
        $rando=rand(0,3);
        if($rando==0){
          return "interesting";
        }
        else if ($rando==1){
          return "feeling welcome";
        }
        else if ($rando==2){
          return "chilling";
        }
        else {
          return "unnecessary";
        }
      }
    }
  }
  public function popfirstsecondadjective($returnedvalue){
    
    $bar=explode("|",$returnedvalue);
    $discardthis=array_shift($bar);
    $second=array_shift($bar);
    //if (count($bar>0)){
      if($second=="taste"){
        return $bar[0];
      }
      else if($second=="see"||$second=="hear"){
        return $bar[0];
      }
      else {
        $c=rand(0,3);
        if($c==0){
          return "ok";
        }
        else if($c==1){
          return "great";
        }
        else if($c==2){
          return "okay";
        }
        else
        {
          return "truth";
        }
      }
      //}
      /*
    else return "it";
    $rand=rand(0,3);
    if($rand==0){
      return "a loving soul";
    }
    else if($rand==1){
      return "a beautiful person";
    }
    else if($rand==2){
      return "someone never forgotten";
    }
    else {
      return "the archangel";
    }
      */
  }
  public function popfirstcheckemotionsnoun($returnedvalue){ /*Note to self: create an object such as a turnip
and assign it an attribute for taste of "bitter",
                                                             and then create many things (including the turnip)
                                                             to iterate through the items 
    */
    $noun="";
    //return $returnedvalue;
    $bar=explode("|",$returnedvalue);
    //$bar2=explode(" ",$bar[0]);
    foreach($bar as $value){
    shuffle($bar);
    $duple=explode(",",$value);
    $universe = new emotionsanduniversals();
      //echo $duple[0];
      //foreach($bar2 as $duple) {
    //return a value, choose whether or not to create a metaphor
    if($duple[0]=="fear" && $duple[1]>0)
      {
        //add metaphor before return statements, do this later
        /*Note to self: list of functions to use in the input of this function:
        
        1. timeofday::daynight($person) -> output second param == "time"
        2. animal::taste($food) -> output second param  == "taste"
        3. person::see($object) -> output second param == ("see"|"seenothing")
        4. person::hear($object) -> output second param == ("hear"|"hearnothing)
        5. person::inside($insideobjecct) -> output second param == "inside"
        6. person::outside($outsideobject) -> output second param == "outside"
        7. person::age() -> output second param == "age"
        8. person::has($arrobject, $mode, $bool) -> second params == (("inside"|"outside")<-for parts|("has"))
        
        */
        $noun= $universe->fear.$duple[0];
      }
      else if($duple[0]=="fear" && $duple[1]<0)
      {
        $noun= $universe->nofear;  //More variety and randomness to be added later
      }
      else if($duple[0]=="health" && $duple[1]>0)
      {
        $noun= $universe->health;
      }
      else if($duple[0]=="health" && $duple[1]<0)
      {
        $noun= $universe->nohealth;
      }
      else if($duple[0]=="dignity" && $duple[1]>0)
      {
        $noun= $universe->dignity;
      }
      else if($duple[0]=="dignity" && $duple[1]<0)
      {
        $noun= $universe->nodignity;
      }
      else if($duple[0]=="happiness" && $duple[1]>0)
      {
        $noun= $universe->happiness;
      }
      else if($duple[0]=="happiness" && $duple[1]<0)
      {
        $noun= $universe->nohappiness;
      }
      else if($duple[0]=="disgust" && $duple[1]>0)
      {
        $noun= $universe->disgust;
      }
      else if($key=="disgust" && $value<50)
      {
        $noun= $universe->nodisgust;
      }
      else if($key=="intrigue" && $value>50){
        $noun= $universe->intrigue;
      }
      else {
        
        $noun= $universe->nointrigue;
      } 
      if ($noun=="" ){
        $rand=rand(0,3);
        if($rand==0){
          return "baby ";
        }
        else if($rand==1){
          return "dude ";
        }
        else if($rand==2){
          return "person ";
        }
        else {
          return "ladybug ";
        }
      }
      else {
        return $noun;
      }
    }
    //}
  }
}
  class sentence {
  public function preparebody(){      // Add recursion later. Too time consuming now.
      $bodyarray=array("head", "skin", "stomach",
                       "heart", "lung", "bladder", "neck", "foot",
                       "chest", "arm", "hand", "brain", "spine",
                       "back", "gluteus", "torso", "pelvis");
      $person1bodystring=array_rand($bodyarray, 1);
      $return=$person1bodystring;
      $statusrand=rand(0,5);
      shuffle($bodyarray);
      if($statusrand=0){
        $return.=",health,2";
        return $return;
      }
      else if($statusrand=1){
        $return.=",health,-2";
        return $return;
      }
      else if($statusrand=2){
        $return.=",width,2.0";
        return $return;
      }
      else if($statusrand=3){
        $return.=",height,2.0";
        return $return;
      }
      else if($statusrand=2){
        $return.=",width,-2.0";
        return $return;
      }
      else if($statusrand=3){
        $return.=",height,-2.0";
        return $return;
      }
      else if($statusrand=4){
        $return.=",length,2.0";
        return $return;
      }
      else if($statusrand=3){
        $return.=",length,-2.0";
        return $return;
      }
    }
    public function makesentence(){
      //This is long. Put it in a separate initializing function.
    $dogJenny = new animal();
    $dogJenny->name="Jenny";
    $dogJenny->life=false;
    $catKiwi = new animal();
    $catKiwi->name="Kiwi";
    $catKiwi->color="brown";
    $dogSpot = new animal();
    $dogSpot->name="Spot";
    $dogSpot->color="white";
    $house = new thing();
    $house->height=30.0;
    $house->width=80.2;
    $randwhose=rand(0,2);
      if($randwhose==0){
        $house->name=="my house";
      }
      else if($randwhose==1){
        $house->name=="your house";
      }
      else{
        $house->name=="this house";
      }
    $turnip=new food("bitter");
    $turnip->color="yellow";
    $turnip->name="turnip";
    $tree=new plant();
    $tree->color="brown";
    $tree->name="maple tree";
    $tree->height=26.5;
    $evergreen = new plant();
    $tree->color="brown";
    $tree->name="maple tree";
    $tree->height=26.5;
    $bush=new plant();
    $bush->name="flower";
    $bush->height=0.9;
    $biscuit=new food("salty");
    $biscuit->name="biscuit";
    $icecream=new food("sweet");
    $icecream->name="ice cream";
    $chickenbroth=new food("neutral");
    $chickenbroth->name="chicken broth";
    $egg=new food("fatty");
    $egg->name="egg";
    $butter=new food("fatty");
    $macandcheese=new food("fatty");
    $macandcheese->name="mac and cheese";
    $butter->name="butter";
    $candy=new food("sweet");
    $candy->name="candy";
    
    $foodarr=array($biscuit,$icecream,$chickenbroth,$egg,$butter,$turnip);
    
    $animal=new animal();
    $animal->name="daily meals";
    $robertamasterson=new person("heart,health,-1");
    $johnmasterson=new person("heart,health,-1");
    $erinmasterson=new person("brain,health,-1|stomach,length,0.4");
    $priscillagarces=new person("stomach,width,-0.2");
    $priscillagarces->vision=false;
    $aimeesimon=new person("heart,health,1");
    $person=new person($this->preparebody());
    $person2=new person($this->preparebody());
    $person3=new person($this->preparebody());
    $person4=new person($this->preparebody());
    $person5=new person($this->preparebody());
    $person6=new person($this->preparebody());
    $timeofday=new timeofday($person);
    $timeofday=new timeofday($person2);
    $timeofday=new timeofday($person3);
      $song=new song();
      $song->volume+=5;
      $song->rhythmspeed=53;
      $sound=new sound();
      $sound->volume-=4;
      /* 
      1. timeofday::daynight($person) -> output second param == "time"
        2. animal::taste($food) -> output second param  == "taste"
        3. person::see($object) -> output second param == ("see"|"seenothing")
        4. person::hear($object) -> output second param == ("hear"|"hearnothing)
        5. person::inside($insideobjecct) -> output second param == "inside"
        6. person::outside($outsideobject) -> output second param == "outside"
        7. person::age() -> output second param == "age"
        8. person::has($arrobject, $mode, $bool) -> second params == (("inside"|"outside")<-for parts|("has"))
      */
      //actions of people
      $return="";
      $randpers=rand(1,11);
      if($randpers==1){
        $randinside=rand(0,6);
        if($randinside==0){
          $return=$person->taste($bush);
          $return2= $person->name." eats too much ".$candy->name.". ".$this->actualsentence($return);
          $return3="";
          $foods=array($biscuit,$chickenbroth,$egg,$butter,$macandcheese,$turnip);
          $rand=rand(0,2);
          if($rand==2){
            $rand2=rand(0,2);
            if($rand2==0){
              $salty="salty";
              shuffle($foods);
              foreach($foods as $val){
                if($val->taste==$salty){
                  return "But it was ".$salty." like ".$val->name."! ";
                }
                else {
                  return "But I disliked it. ";
                }
              }
            }
            else if($rand2==0){
              $neutral="neutral";
              shuffle($foods);
              foreach($foods as $val){
                if($val->taste==$neutral){
                  return "But it was ".$neutral." and had no taste, like ".$val->name.". ";
                }
                else {
                  return "But I got reflux. ";
                }
              }
            }
            else {
              $bitter="bitter";
              shuffle($foods);
              foreach($foods as $val){
                if($val->taste==$neutral){
                  return "But it was really ".$bitter." for some reason, just like a ".$val->name.". ";
                }
                else {
                  return "How grand! ";
                }
              }
            }
          }
        }
        else if ($randinside==1){
          $return=$person->taste($icecream);
          
          return $person->name." is eating ".$icecream->name."! ".$this->actualsentence($return);
        }
        else if ($randinside==2){
          $return=$person->taste($biscuit);
          return $person->name." did eat a lot of ".$biscuit->name."s. ".$this->actualsentence($return);
        }
        else if ($randinside==3){
          $return=$person->taste($chickenbroth);
          return "And when ".$person->name." eats this ".$chickenbroth->name.". ".$this->actualsentence($return);
        }
        else if ($randinside==4){
          $return=$person->taste($macandcheese);
          return $person->name." ate ".$macandcheese->name." for dinner. ".$this->actualsentence($return);
        }
        else if ($randinside==5){
          $return=$person->taste($egg);
          return $person->name." feasts on the ".$egg->name.". ".$this->actualsentence($return);
        }
        else {
          $return=$person->taste($butter);
          return $person->name." eats ".$butter->name.". ".$this->actualsentence($return);
        }
      }
      else if($randpers==3){
        $return=$person5->taste($animal->meat());
        return $this->actualsentence($return).". ".$person5->name." digests ".$animal->name.". ".$this->actualsentence($animal->meat());
      }
      else if($randpers==4){
        $return=$person3->taste($turnip);
        $rand=rand(0,4);
        if($rand==0){
          return "Ability... ".$this->actualsentence($return).".";
        }
        else if($rand==1){
          return $this->actualsentence($return)." my dear.";
        }
        else if($rand==2){
          return $this->actualsentence($return).", it's boring.";
        }
        else if($rand==3){
          return $this->actualsentence($return).". How weird.";
        }
        else {
          return "How good.";
        }
      }
      else if($randpers==5){
        $return=$person3->see($person);
        $randout=rand(0,3);
        if($randout==0){
          $output1="I used to see ".$person->name.".";
        }
        else if($randout==1){
          $output1="You had a vision of ".$person->name.".";
        }
        else if($randout==2){
          $output1="You beheld ".$person->name." recently?";
        }
        else {
          $output1="Seeing ".$person->name."...";
        }
        return $this->actualsentence($return).$output1." ";
      }
      else if($randpers==6){
        $return=$person4->hear($song);
        if($randout==0){
          $output1="I sing. ";
        }
        else if($randout==1){
          $output1="Musical! ";
        }
        else if($randout==2){
          $output1="Music? ";
        }
        else {
          $output1="Hear the notes. ";
        }
        return $this->actualsentence($return).$output1;
      }
      else if($randpers==7){
        $arrhas=array(new song(), new plant(), new animal());
        $return=$person6->has($arrhas,"owner_of_thing",true);
        $randout1=rand(0,3);
        if ($randout1==0){
          $output1="Do you ";
          $output3="?";
        }
        if ($randout1==1){
          $output1="I";
          $output3=" too.";
        }
        if ($randout1==2){
          $output1="I";
          $output3=".";
        }
        else{
          $output1="But I";
          $output3=".";
          
        }
        return $output1." have it".$output3." ".$this->actualsentence($return);
      }
      else if($randpers==8){
        $arrhas=array(new song(), new plant(), new animal());
        $return=$person6->has($arrhas,"owner_of_thing",true);
        $outrand=rand(0,2);
        if($outrand==0){
          $output1=$person6->name." likes that. ";
        }
        else if($outrand==1){
          $output1=$person6->name." is nice. ";
        }
        else{
          $output1=$person6->name." plays music. ";
        }
        return $output.$this->actualsentence($return);
      }
      else if($randpers==9){
        $arrhas=array(new animal());
        $return=$priscillagarces->has($arrhas,"owner_of_animal",true);
        return "What? ".$this->actualsentence($return);
      }
      else if($randpers==10){
        $return8=$house->inside($dogSpot);
        $return9=$house->outside($bush);
        $zeroOne=rand(0,1);
        if($zeroOne==0){
          $output1=$dogSpot->name." is in ".$house->name;
        }
        else{
          $output1=$bush->name." is ";
          $randnear=rand(0,1);
          if($randnear==0){
            $output1.="outside ";
          }
          else{
            $output1.="near ";
          }
          $output1.=$house->name.". ";
        }
        $randloc2=rand(0,2);
        if($randloc2==0){
          $output1.=$bush->name." is close to ".$house->name;
        }
        else if($randloc2==1){
          $output1.=$bush->name." is by ".$house->name;
        }
        else
        {
          $whichreturn=rand(0,1);
           if($whichreturn==0){
            return $output1.$this->actualsentence($return8); 
          }
          else{
            return $this->actualsentence($return9); 
          }
        }
        
        $randloc=rand(0,5);
        $return=$person4->positionlocalx=$house->positionlocalx+$randloc*5.4;
        return $this->actualsentence($return);
        
      }
      else if($randpers==11){
        $arrhas=array(new animal());
        $return=$aimeesimon->has($arrhas,"owner_of_animal",false);
        return $this->actualsentence($return);
      }
      //I can use a construct parameter to give the person new body parts
  } 
  public function actualsentence($returnedvalue){
    $thought=new thought();
        $noun=$thought->popfirstcheckemotionsnoun($returnedvalue);
        $adjective=$thought->popfirstsecondadjective($returnedvalue);
        $adverb=$thought->checksecondparamadverb($returnedvalue);
        //sentence structure
        $structnum=rand(0,19);
        //question, etc.
        if($structnum==0){
          return "The ".$noun." is ".$adjective." ";
        }
        else if($structnum==1){
          return "How ".$adjective." that person is. ".$adverb." ";
        }
        else if($structnum==2){
          return $adverb."? ";
        }
        else if($structnum==3){
          return "I have you ".$adverb." I am ".$adjective." ";
        }
        else if($structnum==4){
          return "Was he a ".$noun."? ";
        }
        else if($structnum==5){
          return "It's that ".$noun."! ";
        }
        else if($structnum==6){
          return "It's the ".$noun."of mine. ";
        }
        else if($structnum==7){
          return "You're the ".$adjective." but ".$adverb." ";
        }
        else if($structnum==8){
          return "A ".$noun." like that is ".$adverb." ";
        }
        else if($structnum==9){
          return $adverb." yes... ";
        }
        else if($structnum==10){
          return $adverb." ....so I'm happy. ";
        }
        else if($structnum==11){
          return "The ".$noun." is so much of  ".$adverb." ";
        }
        else if($structnum==12){
          $rand=rand(0,2);
          if($rand==0)
          {
            return $adverb.", so  I'm weird. ";
          }
          else if($rand==1)
          {
            return $adverb.", and so... ";
          }
          else {
            return $adverb."... like?";
          }
        }
        else if($structnum==13){
          return "Was she really a ".$noun."? ";
        } 
        else if($structnum==14){
          return "Such a ".$noun."... ";
        } 
        else if($structnum==15){
          return "I think I'm someone ".$adverb.", you know. ";
        }
        else if($structnum==16){
          return "You know, it's a ".$noun.", I see. ";
        }
        else if($structnum==17){
          return "That ".$noun." is very ".$adjective." ";
        }
        else if($structnum==18){
          return "Every time, another ".$adjective." ".$noun." ";
        }
        else{
          return "Why this person is the ".$adjective." I know only ".$adverb." ";
        }
      
  }
}
  //Lets go!
$sentence=new sentence();
    //$thought2=new thought();
$p=$sentence->makesentence();
    /*    if($msg="fear"){
      $p.=$thought2->metaphorsecondlife();
  }*/
    echo $p;
  ?>
