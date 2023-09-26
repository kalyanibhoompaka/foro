
CONTENTS OF THIS FILE
---------------------

* INTRODUCTION
* INSTALLATION
* CONFIGURATION
* USAGE

INTRODUCTION
------------

The Onetrust Cookie Blocking module used to block the webpage cookies based upon the active/Inactive status of the cookie category. It uses the wrapper/helper functions provided by the OneTrust.


INSTALLATION
------------
 
 * This module is an sub module of gdpr_onetrust that REQUIRES gdpr_onetrust to be enabled.
 * Enable the module from admin/modules page.


CONFIGURATION
-------------

 * Navigate to the Configuration > System > GDPR Compliance > Configurations
 * Add Javascript URL along with the cookie category separated by | symbol. The cookie category values should be 2 for Performance cookie, 3 for Functional cookie and 4 for targetting cookie. Update one JS url on each row. Example:/pathtojs/jsfilename.js|2
 *


 USAGE
 -----

 * We used the OneTrust Helper functions to block the cookies from clientside(Optanon.InsertHtml and Optanon.InsertScript).
 * To Block Js files from Site code - Create an object for the GdprBlockjs Class and call the optanonInsertscript() with proper arguments.
 	Eg:
 		$gdpr = GdprBlockjs::Instance();
      /**
         * Function create Optanon.InsertScript
         * @param string $js_path
         *  The javascript file path
         * @param int $js_group
         *  The OneTrust Cookie Category values
         *  ONETRUST_COOKIE_BLOCKING_PERFORMANCE / ONETRUST_COOKIE_BLOCKING_FUNCTIONAL
         *  / ONETRUST_COOKIE_BLOCKING_TARGETTING
         * @param $position
         *  postion of the js script "head"
         * @param array $additional
         *  Array consisting of 3rd and 4th parameter of Optanon.InsertHTML()
         *  Optional
         *  eg:
         *  $additional[0] = 'SomeCallbackFunction'
         *  $additional[1] = '{deleteSelectorContent: false, makeSelectorVisible: true, makeElementsVisible: \'HtmlElementIdToShowOnConsent1\',
         *   \'HtmlElementIdToShowOnConsent2\', deleteElements: \'HtmlElementIdToDeleteOnConsent\']}'
         */
 		$gdpr->optanonInsertscript($js_path, $js_group, $position = "head", $additional = array())


 * To Block HTML Code - Create an object for the GdprBlockjs Class and call the optanonInserthtml() with proper arguments.
 		$gdpr = GdprBlockjs::Instance();
        /**
           * Function create Optanon.InsertHtml
           * @param $element
           *  The HTML to be placed rendered through Optanon.InsertHtml(),
           *  that fires a third party cookie.
           * @param string $selector
           *  The wrapper div id.
           * @param INT $groupid
           *  The OneTrust Cookie Category values
           *  ONETRUST_COOKIE_BLOCKING_PERFORMANCE/ONETRUST_COOKIE_BLOCKING_FUNCTIONAL/ONETRUST_COOKIE_BLOCKING_TARGETTING
           * @param array $additional
           *  Array consisting of 3rd and 4th parameter of Optanon.InsertHTML()
           *  Optional
           * $additional[0] / $additional[1]
           */
        $gdpr->optanonInserthtml($element, $selector,  $groupid, $additional = array())
