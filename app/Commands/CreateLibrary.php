<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateLibrary extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'make:library';
    protected $description = 'Creates a new library in the app/Libraries directory';
    protected $usage = 'make:library [library_name]';
    protected $arguments = [
        'library_name' => 'The name of the library to create'
    ];
    protected $options = [];

    public function run(array $params)
    {
        $libraryName = array_shift($params);

        if (empty($libraryName)) {
            CLI::error('You must provide a library name.');
            return;
        }

        $filePath = APPPATH . 'Libraries/' . $libraryName . '.php';

        if (file_exists($filePath)) {
            CLI::error('Library already exists.');
            return;
        }

        $template = <<<EOD
            <?php

                namespace App\Libraries;

                class $libraryName
                {
                    /**
                     * Constructor
                     */
                    public function __construct()
                    {
                        // Initialization code here
                    }

                    /**
                     * Sample method
                     *
                     * @return string
                     */
                    public function sampleMethod()
                    {
                        return 'This is a sample method in the $libraryName library.';
                    }
                }
            EOD;

        if (!is_dir(APPPATH . 'Libraries')) {
            mkdir(APPPATH . 'Libraries', 0755, true);
        }

        file_put_contents($filePath, $template);

        CLI::write('Library created successfully: ' . $filePath, 'green');
    }
}