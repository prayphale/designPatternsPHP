<?php

class Logger
{
   private $handlers;
   public function __construct(array $handlers)
   {
       $this->handlers = $handlers;
   }

   public function log(string $message, int $level): void
   {
       foreach ($this->handlers as $handler) {
          $handler->log($message, $level);
       }
   }
}

interface Handler
{
  public function log(string $message, int $level): void;
}

class FileLogger implements Handler
{
   public function __construct(string $filename)
   {
     $this->filename = $filename;
   }

  public function log(string $message, int $level): void
  {
    file_put_contents($this->filename, sprintf('[%d] %s', $level, $message), FILE_APPEND);
  }
}

class StdOutLogger implements Handler
{
  public function log(string $message, int $level): void
  {
    $handle = fopen('php://stdout','w');
    fwrite($handle, sprintf('[%d] %s', $level, $message));
    fclose($handle);
  }
}

?>