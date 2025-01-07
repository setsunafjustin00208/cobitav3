<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Class CreateViewComponents
 *
 * This command allows you to create new view files in the app/view/components directory.
 *
 * Usage:
 *  php spark createView:Components
 *
 * Description:
 * - createView:Components: Creates a new view file in the app/view/components directory.
 *
 * Command Prompts:
 * 1. Folder Name: You can specify a custom folder name. If you leave this prompt empty, the default folder (components) will be used.
 * 2. File Name: You must specify a file name for the view file. If you do not provide a file name, you will receive an error message, and the prompt will repeat until a valid file name is provided. If a file with the same name already exists, you will receive an error message, and the prompt will repeat until a unique file name is provided.
 *
 * Example:
 * Creating a Components View:
 *  php spark createView:Components
 *  - Prompt: Enter the folder name (leave empty to use "components")
 *    - Input: customComponents (or leave empty to use components)
 *  - Prompt: Enter the file name (without extension)
 *    - Input: button
 *  This will create a file named button.php in the app/view/customComponents directory (or app/view/components if the folder name was left empty).
 */
class CreateViewComponents extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'createView:Components';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Creates a new view file in the app/view/components directory';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'createView:Components';

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->createView('components');
    }

    /**
     * Handles the folder and file creation logic.
     *
     * @param string $defaultFolder
     */
    private function createView(string $defaultFolder)
    {
        $folderName = CLI::prompt('Enter the folder name (leave empty to use "' . $defaultFolder . '")', '');
        $folderPath = APPPATH . 'views/' . $defaultFolder;

        if (!empty($folderName)) {
            $folderPath .= '/' . $folderName;
        }

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
            CLI::write("Folder '$folderPath' created successfully.", 'green');
        }

        while (true) {
            $fileName = CLI::prompt('Enter the file name (without extension)', null, 'required');

            if (empty($fileName)) {
                CLI::error('File name is required.');
                continue;
            }

            $filePath = $folderPath . '/' . $fileName . '.php';

            if (file_exists($filePath)) {
                CLI::error('File already exists. Please choose a different name.');
                continue;
            }

            file_put_contents($filePath, '');
            CLI::write("File '$fileName.php' created successfully in '$folderPath' folder.", 'green');
            break;
        }
    }
}