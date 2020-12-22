<?php


namespace Vog;


use http\Exception\UnexpectedValueException;

class CommandHub
{
    private const COMMAND_GENERATE = "generate";
    private const COMMAND_FPP_CONVERT = "fpp_convert";

    private const COMMANDS = [self::COMMAND_GENERATE, self::COMMAND_FPP_CONVERT];

    public function run(array $argv)
    {
        switch ($argv[1]){
            case self::COMMAND_GENERATE: $this->runGenerateCommand($argv[2]);
            break;
            case self::COMMAND_FPP_CONVERT: $this->runConvertToFppCommand();
            break;
            default:
                throw new \UnexpectedValueException("Command $argv is not defined. Defined commands are: "
                . implode(", ", self::COMMANDS));
        }
    }

    private function runGenerateCommand(string $targetPath)
    {
        $generate = new Generate();
        $generate->run($targetPath);
    }

    private function runConvertToFppCommand()
    {

    }
}