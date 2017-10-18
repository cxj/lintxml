<?php
/**
 * Checks an XML file for errors according to libxml extension.
 *
 * @package     cxj/lintxml
 * @author      Chris Johnson <cxjohnson@gmail.com>
 * @copyright   2017, Chris Johnson
 * @license     MIT
 */


namespace Cxj\LintXml;

class LintXml
{
    /**
     * @var string - document to be checked, passed as a string.
     */
    protected $docString;

    /**
     * @var \DomDocument
     */
    protected $document;

    /**
     * LintXml constructor.
     * @param $doc string - document string to be checked.
     */
    public function __construct($doc)
    {
        $this->document = new \DomDocument;
        $this->docString = $doc;
    }

    public function loadDocument()
    {
        $doc = $this->docString;

        libxml_use_internal_errors(true);       // Do not display errors.

        if ($this->document->loadXml($doc) === false) {

            $errors = libxml_get_errors();
            foreach ($errors as $error) {
                echo $this->display_xml_error($error, explode("\n", $doc));
            }

            /*
             * Future: Further checks for valid HTML?
            $this->document->loadHtml(
                '<' . '?xml encoding="UTF-8">' . $doc,
                LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);

            if (strpos($doc, '<!') !== 0) {
            }
            */

            return;
        }
        else {
            echo "No parsing errors found." . PHP_EOL;
        }
        libxml_clear_errors();

        return;
    }

    protected function display_xml_error($error, $xml)
    {
        $return  = $xml[$error->line - 1] . "\n";
        $return .= str_repeat('-', $error->column) . "^\n";

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "Warning $error->code: ";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "Error $error->code: ";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "Fatal Error $error->code: ";
                break;
        }

        $return .= trim($error->message) .
            "\n  Line: $error->line" .
            "\n  Column: $error->column";

        if ($error->file) {
            $return .= "\n  File: $error->file";
        }

        return "$return\n\n--------------------------------------------\n\n";
    }
}
