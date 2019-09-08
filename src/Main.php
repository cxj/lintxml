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


use Aura\Cli\CliFactory;
use Aura\Cli\Context;
use Aura\Cli\Context\OptionFactory;
use Aura\Cli\Help;
use Aura\Cli\Status;
use Aura\Cli\Stdio;


/**
 * Class Main
 * Manage command line environment interaction.
 */
class Main
{
    /**
     * @var Stdio Input / output stream object.
     */
    protected $io;

    /**
     * @var boolean Verbose message output enable flag.
     */
    protected $verbose;

    /**
     * @var Help Aura help object.
     */
    protected $help;

    /**
     * @var Context\Getopt Command line options.
     */
    protected $getopt;

    /**
     * @var string - filename to check.
     */
    protected $file;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Get the context and stdio objects.
        // Get the Help/Usage object.
        // Define options & named arguments via getopt based on help definition.
        // Would be nice to have a better way to do this.
        $cli_factory  = new CliFactory;
        $context      = $cli_factory->newContext($GLOBALS);
        $this->io     = $cli_factory->newStdio();
        $this->help   = new LintXmlHelp(new OptionFactory());
        $this->getopt = $context->getopt(array_keys($this->help->getOptions()));
    }

    /**
     * Process a file.
     * @return int
     */
    public function run()
    {
        $status = $this->parseCommandLineOptions();
        if (Status::SUCCESS != $status) {
            return $status;
        }

        if (empty($this->file)) {
            if ($this->verbose) {
                $this->io->outln('<<blue>>Reading from STDIN<<reset>>');
            }
            // Use Standard Input
            $doc = stream_get_contents(STDIN);      // todo?
        }
        else {
            if ($this->verbose) {
                $this->io->outln(
                    "<<blue>>Reading from file {$this->file}<<reset>>");
            }
            $doc = file_get_contents($this->file);    // fixme debug
        }
        if (false === $doc) {
            $this->io->outln('<<red>>Unable to read input file<<reset>>');

            return Status::NOINPUT;
        }

        $xml = new LintXml($doc);

        $xml->loadDocument();

        return Status::SUCCESS;
    }


    /**
     * Verifies correct usage and sets class properties using arguments.
     * @return int
     */
    protected function parseCommandLineOptions()
    {
        $getopt = $this->getopt;

        // If asking for help, or missing the required 2 arguments.
        if ($getopt->get('-h')) {
            $this->usage();

            return (Status::USAGE);
        }

        $this->verbose = $getopt->get('-v');

        $this->file = $getopt->get(1);

        return (Status::SUCCESS);
    }

    /**
     * Output the program's usage text.
     */
    protected function usage()
    {
        // Strip any path nonsense.
        $program = basename(realpath($this->getopt->get(0)));
        if (empty($program)) {
            // Extra double-plus fallback on realpath() error.  :-p
            $program = basename(__FILE__);
        }
        $this->io->outln($this->help->getHelp($program));
    }
}
