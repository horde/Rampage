<?php
/**
 * Inherited from the original H4 rampage project
 */
declare(strict_types=1);

namespace Horde\Rampage;

class Environment
{
    public function setup()
    {
        set_magic_quotes_runtime(0);
        $this->reverseMagicQuotes();
        $this->reverseRegisterGlobals();
    }

    /**
     * @author Ilia Alshanetsky <ilia@php.net>
     */
    public function reverseMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $input = [&$_GET, &$_POST, &$_REQUEST, &$_COOKIE, &$_ENV, &$_SERVER];

            foreach ($input as $k => $v) {
                foreach ($v as $key => $val) {
                    if (!is_array($val)) {
                        $key = stripslashes((string) $key);
                        $input[$k][$key] = stripslashes((string) $val);
                        continue;
                    }
                    $input[] =& $input[$k][$key];
                }
            }

            unset($input);
        }
    }

    /**
     * Get rid of register_globals variables.
     *
     * @author Richard Heyes
     * @author Stefan Esser
     * @url http://www.phpguru.org/article.php?ne_id=60
     */
    public function reverseRegisterGlobals()
    {
        if (ini_get('register_globals')) {
            // Variables that shouldn't be unset
            $noUnset = ['GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES'];

            $input = array_merge(
                $_GET,
                $_POST,
                $_COOKIE,
                $_SERVER,
                $_ENV,
                $_FILES,
                $_SESSION ?? []
            );

            foreach (array_keys($input) as $k) {
                if (!in_array($k, $noUnset, true) && isset($GLOBALS[$k])) {
                    unset($GLOBALS[$k]);
                }
            }
        }
    }
}
