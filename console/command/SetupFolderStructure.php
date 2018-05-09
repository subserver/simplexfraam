<?php namespace SimplexFraam;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetupFolderStructure extends Command
{
    /**
     * @var OutputInterface $output;
     */
    private $output = null;

    protected function configure()
    {
        $this
            ->setName('init-folder-structure')
            ->setDescription("Initialize the folder structure");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $output->writeln("Generating Structure");
        $mapFile = __DIR__ . "/../../settings/init/directory-structure.php";
        if (!file_exists($mapFile)) {
            $output->writeln("File does not exist: " . $mapFile);
            return 0;
        }

        /**
         * Variable is defined in the $mapFile.
         * @var array $map;
         */
        require_once $mapFile;

        if(!isset($map)){
            $output->writeln('$map is missing from ' . $mapFile);
            return 0;
        }
        $this->generateFolders($map);

    }

    private function generateFolders($map, $parentFolder = __DIR__ . "/../../"){
        foreach($map as $key => $child){
            if(is_array($child)){
                $newPath = $parentFolder . $key;
                self::makeFolder($newPath);
                self::generateFolders($child, $newPath . "/");
            } else {
                $newPath = $parentFolder . $child;
                self::makeFolder($newPath);
            }
        }
    }

    private function makeFolder($path){
        if(!is_dir($path)){
            $this->output->writeln("Generating: " . $path);
            mkdir($path);
        }
    }
}