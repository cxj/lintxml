<?php
/**
 * @file LintXmlHelp.php Replace with one line description.
 *
 * @package     PackageName
 * @author      Chris Johnson <c___@___.com>
 * @copyright   2017, CopyrightHolder
 * @license     Proprietary or Link to OS license
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
