<?php

namespace CaioMarcatti12\QueueManager;

use CaioMarcatti12\Core\ExtractPhpNamespace;
use CaioMarcatti12\Core\Launcher\Annotation\Launcher;
use CaioMarcatti12\Core\Launcher\Enum\LauncherPriorityEnum;
use CaioMarcatti12\Core\Launcher\Interfaces\LauncherInterface;
use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\QueueManager\Annotation\QueueConsumer;
use CaioMarcatti12\QueueManager\Objects\Route;
use CaioMarcatti12\QueueManager\Objects\RoutesQueue;

#[Launcher(LauncherPriorityEnum::BEFORE_LOAD_APPLICATION)]
class RouterLoader implements LauncherInterface
{
    public function handler(): void
    {
        $filesApplication = ExtractPhpNamespace::getFilesApplication();

        $this->parseFiles($filesApplication);
    }

    private  function parseFiles(array $files): void{
        foreach($files as $file){
            $reflectionClass = new \ReflectionClass($file);

            $reflectionAttributes = $reflectionClass->getAttributes(QueueConsumer::class);

            if(Assert::isNotEmpty($reflectionAttributes)) {
                /** @var \ReflectionAttribute $attribute */
                $attribute = array_shift($reflectionAttributes);

                /** @var QueueConsumer $instanceAttributeClass */
                $instanceAttributeClass = $attribute->newInstance();

                $queueName = $instanceAttributeClass->getQueue();

                $this->addRoute($queueName, $reflectionClass->getName(),'handler');
            }
        }
    }

    private function addRoute(string $uri, string $file, $method): void {
        $route = new Route($uri, $file, $method);
        RoutesQueue::add($route);
    }
}