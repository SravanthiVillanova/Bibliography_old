<?php
/**
 * I18N_Translator
 *
 * The I18N_Translator class handles language translations via an Array that is
 * stored in a PHP file.  There is 1 php file per language and upon construction
 * of the class, the appropriate language file is loaded.  Since the
 * translations are stored in array, they are automatically loaded into memory
 * via an include statement.  This minimizes file parsing time as well as 
 * processing overhead.  The class offers function to manage the files as well, 
 * such as creating new language files and adding/deleting of existing
 * translations. Upon destruction, the file is saved.
 *
 * Author: Andrew S. Nagy <asnagy@webitecture.org>
 */

require_once 'PEAR.php';

/**
 * I18N_Translator Class
 *
 * @version     $Revision: 1.5 $
 * @author      Andrew S. Nagy <asnagy@webitecture.org>
 * @package     I18N_Translator
 * @category    I18N
 */
class I18N_Translator
{
    /**
     * Language translation files path
     *
     * @var     string
     * @access  public
     */
    var $path;
    
    /**
     * The specified language.
     *
     * @var     string
     * @access  public
     */
    var $langCode;

    /**
     * An array of the languages available
     *
     * @var     array
     * @access  public
     */
    var $languages = array();
        
    /**
     * Constructor
     *
     * @param   string $langCode    The ISO 639-1 Language Code
     * @access  public
     */
    function I18N_Translator($langCode = null)
    {
        $this->langCode = $langCode;
    }

    /**
     * Translate the phrase
     *
     * @param   string $phrase      The phrase to translate
     * @param   string $langCode    The Language to translate to specified by
     *                              the ISO 639 Language Code
     * @access  public
     * @note    Can be called statically if 2nd parameter is defined and load
     *          method is called before
     */    
    function translate($phrase, $langCode = null)
    {
        if ($langCode != null) {
            $key = 'I18N_Translator_Text_' . $langCode;
        } else {
            $key = 'I18N_Translator_Text_' . $this->langCode;
        }

        if (isset($GLOBALS[$key][$phrase])) {
            return $GLOBALS[$key][$phrase];
        } else {
            return $phrase;
        }
    }
    /*
    function translate2($phrase, $langCode = null)
    {
      if ($langCode == null) {
	$langCode = $this->langCode;
      }
      include_once($this->path . '/' . $langCode . '.inc');
      $name = 'I18N_Translator_Text_' . $langCode;
      $ar = $$name;
      return $ar[$phrase];
    }
    */
    /**
     * Add new language to the scope
     *
     * @param   string $langCode    The ISO 639 Language Code
     * @access  public
     * @static
     * @note    Cannot be called statically
     */     
    function addLanguage($langCode)
    {
        $this->languages[] = $langCode;

        $this->languages = array_unique($this->languages);
        
        // Define Destructor
        register_shutdown_function(array($this, 'save'));
    }
    
    /**
     * Remove a language from the scope
     *
     * @param   string $langCode    The ISO 639 Language Code
     * @access  public
     * @static
     * @note    Cannot be called statically
     */     
    function removeLanguage($langCode)
    {
        $key = array_search($langCode);
        unset($this->languages[$key]);
        
        // Define Destructor
        register_shutdown_function(array($this, 'save'));
    }
    
    function getLanguages()
    {
        $langList = array();
        
        if (is_file($this->path)) {
            $dir = dirname($this->path);
        } else {
            $dir = $this->path;
        }
        
        if (is_dir($dir)) {
           if ($dh = opendir($dir)) {
               while (($file = readdir($dh)) !== false) {
                   if ($pos = strpos($file, '.inc')) {
                       $langList[] = substr($file, 0, $pos);
                   }
               }
           }
           closedir($dh);
        } else {
            return new PEAR_Error('Invalid Path');
        }
        
        return $langList;
    }
    
    /**
     * Define a translation
     *
     * @param   string $phrase      The phrase that has been translated
     * @param   string $translation The phrase translation
     * @param   string $langCode    The language in which the phrase was
     *                              translated.  This is specified by the 
     *                              ISO 639-1 Language Code
     * @access  public
     * @note    Can be called statically if 3rd parameter is defined and load
     *          method is called before hand
     */    
    function setTranslation($phrase, $translation, $langCode = null)
    {
        if ($langCode != null) {
            $GLOBALS['I18N_Translator_Text_' . $langCode][$phrase] = $translation;
            $this->languages[] = $langCode;
        } else {
            $GLOBALS['I18N_Translator_Text_' . $this->langCode][$phrase] = $translation;
        }

        $this->languages = array_unique($this->languages);
                
        // Define Destructor
        register_shutdown_function(array($this, 'save'));
    }
    
    function removeTranslation($phrase)
    {
        foreach ($this->getLanguages() as $lang) {
            print_r(array_keys($GLOBALS['I18N_Translator_Text_' . $lang]), $phrase);
            unset($GLOBALS['I18N_Translator_Text_' . $lang][$phrase]);
        }

        // Define Destructor
        register_shutdown_function(array($this, 'save'));
    }
    
    /**
     * Loads the translation files into scope
     *
     * @param   string $path        The file to load or directory containing
     *                              translation files to load.   
     * @access  public
     * @static
     * @note    Can be called statically
     */    
    function load($path)
    {
        // Load files in specified path
        if (is_file($path)) {
            include($path);
            $this->languages[] = substr(filename($path), 0, strpos(filename($path), '.'));
        } else {            
            if ($dh = opendir($path)) {
                if ($this->langCode != '' && is_file($path . '/' . $this->langCode . '.inc')) {
                    include($path . '/' . $this->langCode . '.inc');
                } else {
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($path . '/' . $file) && stristr($file, '.inc')) {
                            include($path . '/' . $file);
                            $this->languages[] = substr($file, 0, strpos($file, '.'));
                        }
                    }
                }
            } else {
                return new PEAR_Error("Cannot open $path for reading");
            }
        }
        
        
        // Define available languages
        if (isset($this)) {
            $result = array_keys($GLOBALS, 'I18N_Translator_Text_');
            foreach ($result as $lang) {
                $this->languages[] = substr($lang, strlen('I18N_Translator_Text_'));
            }
            
            $this->setPath($path);
        }
        
        $this->languages = array_unique($this->languages);
    }
    
    /**
     * Unset the translation data from scope
     *
     * @access  public
     * @note    Cannot be called statically
     */    
    function unload()
    {
        if (count($languages)) {
            foreach($languages as $lang) {
                unset($GLOBALS['I18N_Translator_Text_' . $lang]);
            }
        }
    }
    
    /**
     * Defines the path to the translation files
     *
     * @param   string $path        The path to the translation files.
     * @access  public
     * @note    Cannot be called statically
     */    
    function setPath($path)
    {
        $this->path = $path;
    }
    
    /**
     * Saves the translation data to php include files
     *
     * @param   string $path        The file to load or directory containing
     *                              translation files to load.   
     * @access  public
     * @static
     * @note    Should only be called statically
     * @todo    Do not overright entire file, similiar to DB_Dataobject's
     *          createTables.php
     */    
    function save()
    {
        if ($this->path != null) {
            if (count($this->languages)) {
                foreach($this->languages as $lang) {
                    if ($fp = @fopen($this->path . '/' . $lang . '.inc', 'w+')) {
                        $langvar = 'I18N_Translator_Text_' . $lang;
                        global $$langvar;
                        fwrite($fp, "<?php\n");
                        fwrite($fp, "/* Automatically Generated by I18N_Translator */\n");
                        fwrite($fp, 'global $' . $langvar . ";\n");
                        foreach($$langvar as $phrase => $translation) {
                            fwrite($fp, '$' . $langvar . "['$phrase'] = ");
                            
                            //if (strstr($translation, "'")) {
                            //     fwrite($fp, '"$translation"' . ";\n");
                            //} else {
                            //     fwrite($fp, "'$translation';\n");
                            //}
                            
                            fwrite($fp, '"' . $translation . '"' . ";\n");
                        }
                        fwrite($fp, "?>");
                    } else {
                        return new PEAR_Error("Cannot save file in $this->path");
                    }
                }
            } else {
                return new PEAR_Error("Nothing to save");
            }
        } else {
            return new PEAR_Error("A path to save the file was not specified");
        }
    }
}
?>