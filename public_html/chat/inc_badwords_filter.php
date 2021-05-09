<?php
function replace_badwords($text) {
	//i'm providing here some exmaples of bad words filtering.
	//you can select/modify the method you like.

	
	//simple check for sequences of symbols 
	// in php 5 cvs you can try str_ireplace
	/*
	$bad_words = array("fuck", "shit", "sheisse", "arschloch");
	$good_words = "[...]";
	$text = str_replace($bad_words, $good_words, $text);
	*/
	
	//check for 'F! Uccc~k' and Co
	$bad_words = array(
			"'[fF]{1,5}[^[:alnum:]]{0,10}[uUaA]{1,5}[^[:alnum:]]{0,10}[cC]{1,5}[^[:alnum:]]{0,10}[kK]{1,5}'",
			"'[sS]{1,5}[^[:alnum:]]{0,10}[hH]{1,5}[^[:alnum:]]{0,10}[iI]{1,5}[^[:alnum:]]{0,10}[tT]{1,5}'",
			"'[sS]{1,5}[^[:alnum:]]{0,10}[hH]{1,5}[^[:alnum:]]{0,10}[eE]{1,5}[^[:alnum:]]{0,10}[iI]{1,5}[^[:alnum:]]{0,10}[sS�]{1,5}'",
			"'[aA]{1,5}[^[:alnum:]]{0,10}[rR]{1,5}[^[:alnum:]]{0,10}[sS]{1,5}[^[:alnum:]]{0,10}[cC]{1,5}[^[:alnum:]]{0,10}[hH]{1,5}'"
			);
	$good_words = "[...]";
	if (function_exists("preg_replace")) {
		$text = preg_replace($bad_words,$good_words, $text);
	}
	
	//russian 'mat'
	/*
		$bad_words = array( 
            "'[��xXHh]{1,5}[^0-9A-Za-z�-��-�]*[��yYuU]{1,5}[^0-9A-Za-z�-��-�]*[uU������ijIJeE�Ÿ�]{1,5}'", 
            "'\)\([^0-9A-Za-z�-��-�]*[��yYuU]{1,5}[^0-9A-Za-z�-��-�]*[uU������ijIJeE�Ÿ�]{1,5}'", 
            "'[��pPn]{1,5}[^0-9A-Za-z�-��-�]*[��iI]{1,5}[^0-9A-Za-z�-��-�]*[��3zZsS]{1,5}[^0-9A-Za-z�-��-�]*[��dD]{1,5}'", 
            "'[ ��uU����jJ��yY��aA]{1,5}[^0-9A-Za-z�-��-�]*[��eE]{1,5}[^0-9A-Za-z�-��-�]*[��bB6]{1,5}[^0-9A-Za-z�-��-�]*[������aAiIuU]{1,5}'", 
            "'[��cCsS(]{1,5}[^0-9A-Za-z�-��-�]*[��uUyY]{1,5}[^0-9A-Za-z�-��-�]*[4��]?[^0-9A-Za-z�-��-�]*[��kK]{1,5}[^0-9A-Za-z�-��-�]*[��������aAuUyYeEiI]{1,5}'", 
            "'[fF]{1,5}[^0-9A-Za-z�-��-�]*[uUaA]{1,5}[^0-9A-Za-z�-��-�]*[cC]{1,5}[^0-9A-Za-z�-��-�]*[kK]{1,5}'", 
            "'[��zZ]{1,5}[^0-9A-Za-z�-��-�]*[hH]?[^0-9A-Za-z�-��-�]*[��oO]{1,5}[^0-9A-Za-z�-��-�]*[��pPp]{1,5}'", 
            "'[ ,?!\.][��bB6]{1,5}[^0-9A-Za-z�-��-�]*[��lL]{1,5}[^0-9A-Za-z�-��-�]*[��jJyY]{1,5}'", 
            "'[��pP]{1,5}[^0-9A-Za-z�-��-�]*[��iI]{1,5}[^0-9A-Za-z�-��-�]*[��dD]{1,5}[^0-9A-Za-z�-��-�]*[������oOaAeE]{1,5}'" 
            ); 
			
	$good_words = "[...]"; 
	$text = preg_replace($bad_words,$good_words, $text);
	*/
	return $text;
}
?>