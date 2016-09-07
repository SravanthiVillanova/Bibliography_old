<?php
/**
 * Table Definition for card
 */
require_once 'DB/DataObject.php';

class Card extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'card';                            // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $number;                          // int(11)  not_null
    var $section_id;                      // int(11)  
    var $chapter_id;                      // int(11)  
    var $part_id;                         // int(11)  
    var $heading_id;                      // int(11)  
    var $keyword;                         // string(100)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Card',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function getWorks()
    {
        $workList = array();
        
        $work = new Work();
        $sql = "SELECT `work`.* FROM work_card, `work` WHERE `work`.id = work_card.work_id AND work_card.card_id = '$this->id'";
        $work->query($sql);
        if ($work->N) {
            while ($work->fetch()) {
                $workList[] = $work;
            }
        }
        
        return $workList;
    }
    
    function getSection()
    {
        require_once('classes/Section.php');
        return Section::staticGet('id', $this->section_id);
    }
    
    function getChapter()
    {
        require_once('classes/Chapter.php');
        return Chapter::staticGet('id', $this->chapter_id);
    }
    
    function getPart()
    {
        require_once('classes/Part.php');
        return Part::staticGet('id', $this->part_id);
    }
    
    function getHeading()
    {
        require_once('classes/Heading.php');
        return Heading::staticGet('id', $this->heading_id);
    }
    
    function getBranchString()
    {
        $section = $this->getSection();
        if ($section != null) {
            $str = htmlspecialchars($section->title);
            $phrase = $section->title;
            $chapter = $this->getChapter();
            if ($chapter != null) {
                $str .= ' > ' . htmlspecialchars($chapter->title);
                $phrase = $chapter->title;
                $part = $this->getPart();
                if ($part != null) {
                    $str .= ' > ' . htmlspecialchars($part->title);
                    $phrase = $part->title;
                    $heading = $this->getHeading();
                    if ($heading != null) {
                        $str .= ' > ' . htmlspecialchars($heading->title);
                        $phrase = $heading->title;
                    }
                }
            }
            $link .= "<a href=\"index.php?lookfor=$phrase\">$str</a>\n";
        }
        
        return $link;
    }

}
?>