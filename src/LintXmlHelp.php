<?php
/**
 * @file LintXmlHelp.php Replace with one line description.
 *
 * @package     cxj/lintxml
 * @author      Chris Johnson <cxjohnson@gmail.com>
 * @copyright   2019, CopyrightHolder
 * @license     MIT
 *
 * Created: 8/4/17 9:19 AM
 */

namespace Cxj\LintXml;

    use Aura\Cli\Help;

class LintXmlHelp extends Help
{
    /**
     * Sets the arguments and options accepted, plus brief help text.
     * @return null|void
     */
    protected function init()
    {
        $this->setSummary('Checks for XML problems.');
        $this->setUsage('[-hv] [file]');
        $this->setOptions(
            array(
                'v,verbose' => "Verbose output.",
                'h,help'    => "This help.",
            ));

        $description = <<<EOT
Reads an XML file and reports on any XML errors detected.
EOT;
        $this->setDescr($description);
    }
}
